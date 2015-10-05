<?php namespace App\Models\Repositories;

use App\Models\Entities\Animal;
use App\Models\Entities\Photo;
use App\Models\Entities\User;

interface PhotoRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param $user
     * @return object[]|Photo[]
     */
    public function allForUser($user);

    /**
     * @param object|Photo $photo
     * @param object|Pet $animal
     * @param array $data
     */
    public function attachToAnimal($photo, $animal, $data = []);

    /**
     * @param array $input
     * @param object|User $user
     * @return object|Photo
     */
    public function createForUser($input, $user);

    /**
     * @param int $id
     * @param object|User $user
     */
    public function deleteForUser($id, $user);

    /**
     * @param object|Photo $photo
     * @param object|Pet $animal
     */
    public function detachFromAnimal($photo, $animal);

    /**
     * @param int $id
     * @param object|Pet $animal
     * @return object|Photo
     */
    public function getForAnimal($id, $animal);

    /**
     * @param int $id
     * @param Pet $animal
     * @return Photo
     */
    public function getForAnimalPlain($id, $animal);

    /**
     * @param int $id
     * @param object|User $user
     * @return object|Photo
     */
    public function getForUser($id, $user);

    /**
     * @param $id
     * @param User $user
     * @return Photo
     */
    public function getForUserPlain($id, $user);

    /**
     * @param int $id
     * @param array $input
     * @param object|User $user
     * @return object|Photo
     */
    public function updateForUser($id, $input, $user);

    /**
     * @param $image
     * @param object|User $user
     * @return string
     */
    public function uploadImage($image, $user);
}
