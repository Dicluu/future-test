<?php

namespace App\Service\Notebook;

use App\Http\Requests\Notebook\PaginationRequest;
use App\Http\Resources\NotebookResource;
use App\Models\Notebook;

class Service {

    public function index($data) {
        // Если объявлен параметр paginate=true, тогда ответ будет возвращен с использованием пагинации.
        if (isset($data['paginate']) && $data['paginate']) {

            // объявление дефолтного значения количества объектов пагинации.
            $count = 10;
            // и изменение кол-ва объектов в пагинации, если есть объявленный параметр.
            if (isset($data['count'])) {
                $count = $data['count'];
            }
            // Если параметр simple=true, тогда пагинация будет без использования HATEOAS.
            if (isset($data['simple']) && $data['simple']) {
                // Вариант пагинации с исключительно только объектами в теле ответа.
                $notebooks = Notebook::simplePaginate($count)->items();
                return NotebookResource::collection($notebooks);
            }

            // Вариант пагинации с использованием HATEOAS из коробки.
            $notebooks = Notebook::simplePaginate($count);
            return NotebookResource::collection($notebooks);
        }

        return NotebookResource::collection(Notebook::all());
    }

}
