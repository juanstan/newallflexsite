<?php namespace App\Models\Repositories;

use App\Models\Entities\Pet;
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
     * @param object|Pet $pet
     * @param array $data
     */
    public function attachToPet($photo, $pet, $data = []);

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
     * @param object|Pet $pet
     */
    public function detachFromPet($photo, $pet);

    /**
     * @param int $id
     * @param object|Pet $pet
     * @return object|Photo
     */
    public function getForPet($id, $pet);

    /**
     * @param int $id
     * @param Pet $pet
     * @return Photo
     */
    public function getForPetPlain($id, $pet);

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

    /**
     * @param $image
     * @param object|Vet $vet
     * @return string
     */
    public function uploadVetImage($image, $vet);
}
