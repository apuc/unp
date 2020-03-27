<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;

/**
 * Хелперы обработки адреса страницы
 * Используется как фасад.
 */
class URI
{
    /**
     * Возвращает хост проекта (без следующего уровня)
     *
     */
    public function projectHost(): string
    {
        return parse_url(config('app.url'), PHP_URL_HOST);
    }

	/**
	 * Генерирует составной slug, состоящий из id и name. Например:  123-mama-mila-ramu
	 *
	 */
	public function asSlug(int $id, string $name): string
	{
		return str_slug(str_limit($name, config('interface.slug', 50), null)) . '-' . $id;
	}

	/**
	 * Извлекает Id из составного slug. Предполагается, что id первый в списке
	 *
	 */
	public function asId(string $slug): int
	{
		$arr = explode('-', $slug);
		return (int)end($arr);
	}
}
