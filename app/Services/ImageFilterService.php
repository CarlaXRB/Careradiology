<?php

namespace App\Services;

use Imagick;

class ImageFilterService
{
    public function applyFilters(string $imagePath): string
    {
        $imagick = new Imagick($imagePath);

        // Aquí puedes aplicar los filtros que necesites
        // Ejemplo de aplicar un filtro de negativo
        $imagick->negateImage(false); // false para negativo normal

        // Ejemplo de aplicar un filtro de aumento de contraste
        $imagick->modulateImage(100, 150, 100); // Aumentar el contraste al 150%

        // Guardar la imagen filtrada
        $filteredImagePath = pathinfo($imagePath, PATHINFO_DIRNAME) . '/filtered_' . pathinfo($imagePath, PATHINFO_BASENAME);
        $imagick->writeImage($filteredImagePath);
        $imagick->destroy();

        return $filteredImagePath; // Retorna la ruta de la imagen filtrada
    }
}
