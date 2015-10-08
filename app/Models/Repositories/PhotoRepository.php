<?php namespace App\Models\Repositories;

use App\Models\Entities\User;
use App\Models\Entities\Animal;
use App\Models\Entities\Photo;
use Carbon\Carbon;
use Validator;
use Image;

class PhotoRepository extends AbstractRepository implements PhotoRepositoryInterface
{

    protected $classname = 'App\Models\Entities\Photo';

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->user = $userRepositoryInterface;
    }

    public function setUser($user)
    {
        $this->user = is_numeric($user) ? $this->repository->get($user) : $user;

        return $this;
    }
    /**
     * @param Pet $animal
     * @return object[]
     */
    public function allForAnimal($animal)
    {
        return $animal->photos()->with('animals')->get();
    }

    /**
     * @param User $user
     * @return Photo[]
     */
    public function allForUser($user)
    {
        return $user->uploadedPhotos()->with('animals')->get();
    }

    /**
     * @param Photo $photo
     * @param Pet $animal
     * @param array $data
     * @return void
     */
    public function attachToAnimal($photo, $animal, $data = [])
    {
        if($photo->pets()->find($animal->id) == null)
        {
            $photo->pets()->attach($animal, $data);
        }
    }

    /**
     * @param array $input
     * @param User $user
     * @return Photo
     */
    public function createForUser($input, $user)
    {
        return parent::create([
                'uploading_user_id' => $user->id
            ] + $input);
    }


    /**
     * @param array $input
     * @param Vet $vet
     * @return Photo
     */
    public function createForVet($input, $vet)
    {
        return parent::create([
                'uploading_vet_id' => $vet->id
            ] + $input);
    }

    /**
     * @param array $image
     * @param User $user
     * @return user
     */
    public function findProfilePictureOrCreate($image, $user)
    {
        if($user->photo_id == NULL)
        {
            $photo = array(
                'title' => $user->id,
                'location' => $image
            );

            $image = $this->createForUser($photo, $user);
        }

        $this->checkIfProfileImageNeedsUpdating($image, $user);
        return $user;
    }

    /**
     * @param array $image
     * @param User $user
     */
    public function checkIfProfileImageNeedsUpdating($image, $user)
    {
        if($user->photo_id == NULL)
        {
            $user->photo_id = $image->id;
            $user->save();
        }
        else
        {
            $socialData = [
                'location' => $image,
            ];

            $dbData = [
                'location' => $user->photo->location,
            ];

            if (!empty(array_diff($socialData, $dbData)))
            {
                $user->photo_id = $image->id;
                $user->save();
            }
        }
    }

    /**
     * @param Photo $photo
     * @param Pet $animal
     * @return void
     */
    public function detachFromAnimal($photo, $animal)
    {
        $photo->animals()->detach($animal);
    }

    /**
     * @param $id
     * @param User $user
     */
    public function deleteForUser($id, $user)
    {
        $object = $this->getForUser($id, $user);
        $object->delete();
    }

    /**
     * @param int $id
     * @param Pet $animal
     * @return Photo
     */
    public function getForAnimal($id, $animal)
    {
        return $animal->photos()->with('animals')->findOrFail($id);
    }

    /**
     * @param int $id
     * @param Pet $animal
     * @return Photo
     */
    public function getForAnimalPlain($id, $animal)
    {
        return $animal->photos()->findOrFail($id);
    }

    /**
     * @param $id
     * @param User $user
     * @return Photo
     */
    public function getForUser($id, $user)
    {
        return $user->uploadedPhotos()->with('animals')->findOrFail($id);
    }

    /**
     * @param $id
     * @param User $user
     * @return Photo
     */
    public function getForUserPlain($id, $user)
    {
        return $user->uploadedPhotos()->findOrFail($id);
    }

    /**
     * @param int $id
     * @param array $input
     * @param User $user
     * @return Photo
     */
    public function updateForUser($id, $input, $user)
    {
        $object = $this->getForUser($id, $user);
        $object->fill($input);
        $object->save();

        return $object;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @param User $user
     * @return string
     */
    public function uploadImage($image, $user)
    {
        $location = null;

        if ($image->isValid())
        {
            $fileObject = $image->openFile();
            $fileData = $fileObject->fread($fileObject->getSize());
            dd($fileData);
            $fileName = preg_replace("/[+=\\/]+/", '', base64_encode(hash('sha512', $fileData . $image->getClientOriginalName() . (string)$user->id . Carbon::now()->toIso8601String(), true))) . '.' . strtolower($image->getClientOriginalExtension());
            $fileLocation = 'uploads/users/' . (string)$user->id;
            if (!@is_dir($fileLocation)) {
                @mkdir($fileLocation, 0755, true);
            }
            $publicPath = $fileLocation . '/' . $fileName;

            Image::make($image->getRealPath())->fit(200)->save($publicPath);

            $image->move(storage_path($fileLocation), $fileName);
            $location = $fileLocation . '/' . $fileName;


        }
        return $location;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @param Vet $vet
     * @return string
     */
    public function uploadVetImage($image, $vet)
    {
        $location = null;

        if ($image->isValid())
        {
            $fileObject = $image->openFile();
            $fileData = $fileObject->fread($fileObject->getSize());
            $fileName = preg_replace("/[+=\\/]+/", '', base64_encode(hash('sha512', $fileData . $image->getClientOriginalName() . (string)$vet->id . Carbon::now()->toIso8601String(), true))) . '.' . strtolower($image->getClientOriginalExtension());
            $fileLocation = 'uploads/vets/' . (string)$vet->id;
            if (!@is_dir($fileLocation)) {
                @mkdir($fileLocation, 0755, true);
            }
            $publicPath = $fileLocation . '/' . $fileName;

            Image::make($image->getRealPath())->fit(200)->save($publicPath);

            $image->move(storage_path($fileLocation), $fileName);
            $location = $fileLocation . '/' . $fileName;


        }
        return $location;
    }

    /**
     * @param $input
     * @return \Illuminate\Validation\Validator
     */
    public function getCreateValidator($input)
	{
		return Validator::make($input,
		[
			'title' => ['max:255'],
            'image_path' => ['required', 'image']
		]);
	}

    /**
     * @param $input
     * @return \Illuminate\Validation\Validator
     */
    public function getUpdateValidator($input)
	{
		return Validator::make($input,
		[
			'title' => ['required','max:255'],
		]);
	}
}
