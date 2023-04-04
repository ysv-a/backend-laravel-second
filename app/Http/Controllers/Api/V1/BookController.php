<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Book;
use App\Http\Controllers\Controller;
use App\JsonApi\V1\Books\BookRequest;

use LaravelJsonApi\Laravel\Http\Controllers\Actions;
use LaravelJsonApi\Laravel\Http\Requests\AnonymousQuery;

class BookController extends Controller
{
    use Actions\FetchMany;
    use Actions\FetchOne;
    use Actions\Store;
    use Actions\Update;
    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;

    public function creating(BookRequest $request, AnonymousQuery $query): void
    {
        $authors_custom = $request->all()['data']['attributes']['authors_custom'];
        // dd($authors_custom);
    }
}
