<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Image, Exception;
use Illuminate\Support\Facades\Validator;

class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(){
        return $this->model->ordered();
    }

    /**
     * Fill and create a new entry or update it if it exists
     *
     * @param array $data
     *
     * @return bool
     */
    public function save(array $data): bool
    {
        if (count($this->validate($data)) == 0) {
            $entity = $this->model::where('remote_id', $data['remote_id'])->firstOrNew();
            $entity->fill(Arr::only($data, $this->model->getFillable()));
            $result = $entity->save();
            if ($result && isset($data['image']) && $data['image']) {
                $this->saveImage($data['image'], $entity->id);
            }
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Save the image for the current model instance
     *
     * @param string $imageUrl
     * @param int $entityId
     *
     * @return bool
     */
    public function saveImage(string $imageUrl, int $entityId): bool
    {
        try {
            $className = $this->model->getClassName();
            $image = Image::make($imageUrl);
            $mimeType = $image->mime();
            $savePath = storage_path('app/public/images/' . $className);
            if (!is_dir($savePath)) {
                mkdir($savePath, 0755, true);
            }
            if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
                $image->save($savePath . '/' . ((int) $entityId) . '.png');
            }
        } catch (Exception $e) {
            if (config('logging.log_application_warnings')) {
                Log::warning('Error while fetching image for ' . $className . ' ' . $entityId . '(' . $imageUrl . '):' . $e->getMessage());
            }
        }
        return false;
    }

    /**
     * Validate the input data and
     * return an array of invalid fields
     *
     * @param array $data
     *
     * @return array
     */
    public function validate(array $data): array
    {
        $validator = Validator::make($data, $this->model::$validateRules);
        if ($validator->fails()) {
            return $validator->errors()->keys();
        }
        return [];
    }
}
