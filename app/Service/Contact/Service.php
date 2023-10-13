<?php

namespace App\Service\Contact;

use App\Http\Resources\ContactResource;
use App\Models\Contact;

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
                $contacts = Contact::simplePaginate($count)->items();
                return ContactResource::collection($contacts);
            }

            // Вариант пагинации с использованием HATEOAS из коробки.
            $contacts = Contact::simplePaginate($count);
            return ContactResource::collection($contacts);
        }

        return ContactResource::collection(Contact::all());
    }

}
