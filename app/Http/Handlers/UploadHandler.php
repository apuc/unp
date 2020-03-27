<?php

namespace App\Http\Handlers;

use Storage;
use Illuminate\Http\Request;

class UploadHandler
{
	/**
	 * объект Request
	 *
	 * @var Request
	 */

	private $request;

	/**
	 * конструктор
	 *
	 * @param Request $request
	 */

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	/**
	 * загрузка файлов
	 *
	 * @param Model $model  модель
	 * @param array $fields массив полей файлов
	 *                      в Request
	 */

	public function file($model, array $fields)
	{
		if (false === ($fields = $this->needToProcess($fields)))
			return;

		foreach ($fields as $field) {

			// если файл нужно удалить
			if (null !== $this->request->{ $field . '_clean' }) {
				// удаляем
				Storage::disk('public')->delete($this->folder($model) . '/' . $model->$field);

				// сбрасываем значение поля в реквесте
				$this->request->$field = false;

				// сбрасываем значение поля в модели
				$model->$field = null;
			}

			else {
				// если в модели уже прописан файл
				if ($model->$field !== null)
					// удаляем его
					Storage::disk('public')->delete($this->folder($model) . '/' . $model->$field);

				// записываем файл
				$file		= $this->request->file($field);
				$fileName	= $this->generateName($file, $model);

				Storage::disk('public')
					->put(
						$this->folder($model) . '/' . $fileName,
						file_get_contents(
							$file->getRealPath()
						)
					)
				;

				// сбрасываем значение поля
				$this->request->$field = false;

				// переносим имя файла в модель
				$model->$field = $fileName;
			}
		}

		// если были загрузки, то сохраняем состояние модели
		$model->save();
	}

	/**
	 * уничтожение файлов
	 *
	 * @param Model $model  модель
	 * @param array $fields массив полей файлов
	 *                      в Request
	 */

	public function destroy($model, array $fields)
	{
		foreach ($fields as $field)
			if (null !== $model->$field)
				Storage::disk('public')->delete($this->folder($model) . '/' . $model->$field);
	}

	/**
	 * нужно ли обработать поле?
	 *
	 * @return array|false
	 *
	 * @param array $fields
	 */

	private function needToProcess($fields)
	{
		$results = [];

		foreach ($fields as $field) {
			// если поле уже обработано
			if (false === $this->request->$field)
				// пропускем обработку
				continue;

			// если файл НЕ прислан
			if (
					null === $this->request->$field
				&&	null === $this->request->{ $field . '_clean' }
			)
				// пропускем обработку
				continue;

			// если не массив
			if (!is_object($this->request->$field) && null === $this->request->{ $field . '_clean' })
				continue;

			$results[] = $field;
		}

		return !empty($results) ? $results : false;
	}

	/**
	 * генератор уникально имени файла
	 *
	 * @return string
	 *
	 * @param UploadedFile $file загруженный файл
	 * @param Model $model модель
	 * @param integer $i
	 */

	private function generateName($file, $model, $i = 0)
	{
		$name = ''
			. $model->id

			. '_' . str_slug(
					basename(
						$file->getClientOriginalName(),
						'.' . $file->getClientOriginalExtension()
					),
					 '_'
				 )

			. (($i > 0) ? '_' . $i : '')

			. '.' . $file->getClientOriginalExtension()
		;

		if (Storage::disk('public')->has($this->folder($model) . '/' . $name))
			return $this->generateName($file, $model, ++$i);

		return $name;
	}

	/**
	 * получаем имя папки
	 *
	 * @param Model $model модель
	 *
	 * @return string
	 */

	private function folder($model)
	{
		return str_plural(
			mb_strtolower(
				class_basename(
					get_class($model)
				)
			)
		);
	}
}
