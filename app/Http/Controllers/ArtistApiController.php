<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistApiController extends Controller
{
    /**
     * @api {get} http://localhost:8000/api/artists Get all artists
     * @apiName GetArtists
     * @apiGroup Artist
     *
     * @apiSuccess {Object[]} songs List of artists.
     * @apiSuccess {Number} songs.id Artist ID.
     * @apiSuccess {String} songs.name Artist name.
     * @apiSuccess {String} songs.nationality Artist nationality.
     * @apiSuccess {String} songs.image Artist image URL.
     * @apiSuccess {String} songs.description Artist description.
     * @apiSuccess {String} songs.is_band Indicates if the artist is a band ("yes"/"no").
     *
     * @apiSuccessExample {json} Success Response:
     * HTTP/1.1 200 OK
     * {
     *   "songs": [
     *     {
     *       "id": 1,
     *       "name": "The Beatles",
     *       "nationality": "British",
     *       "image": "beatles.jpg",
     *       "description": "Legendary rock band from Liverpool.",
     *       "is_band": "yes"
     *     }
     *   ]
     * }
     */
    public function index() {
        $songs = Artist::all();
        return response()->json(['songs' => $songs]);
    }

    /**
     * @api {post} http://localhost:8000/api/artist Create a new artist
     * @apiName CreateArtist
     * @apiGroup Artist
     *
     * @apiBody {String} name Artist name (required).
     * @apiBody {String} nationality Artist nationality (required).
     * @apiBody {String} [image] Artist image URL (optional).
     * @apiBody {String} description Artist description (required).
     * @apiBody {String} is_band Whether the artist is a band ("yes" or "no") (required).
     *
     * @apiSuccess {Object} product Created artist data.
     *
     * @apiSuccessExample {json} Success Response:
     * HTTP/1.1 201 Created
     * {
     *   "product": {
     *     "id": 2,
     *     "name": "Adele",
     *     "nationality": "British",
     *     "image": "adele.jpg",
     *     "description": "Pop and soul singer-songwriter.",
     *     "is_band": "no"
     *   }
     * }
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'image' => 'nullable|string',
            'description' => 'required|string',
            'is_band' => 'required|string'
        ]);

        $product = Artist::create($request->all());
        return response()->json(['product' => $product], 201);
    }

    /**
     * @api {put} http://localhost:8000/api/artist/:id Update an artist
     * @apiName UpdateArtist
     * @apiGroup Artist
     *
     * @apiParam {Number} id Artist unique ID.
     *
     * @apiBody {String} [name] Artist name.
     * @apiBody {String} [nationality] Artist nationality.
     * @apiBody {String} [image] Artist image URL.
     * @apiBody {String} [description] Artist description.
     * @apiBody {String} [is_band] Whether the artist is a band ("yes" or "no").
     *
     * @apiSuccess {Object} product Updated artist data.
     *
     * @apiSuccessExample {json} Success Response:
     * HTTP/1.1 200 OK
     * {
     *   "product": {
     *     "id": 2,
     *     "name": "Adele (Updated)",
     *     "nationality": "British",
     *     "image": "adele_updated.jpg",
     *     "description": "Updated biography...",
     *     "is_band": "no"
     *   }
     * }
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'nullable|string|max:255',
        'nationality' => 'nullable|string|max:255',
        'image' => 'nullable|string',
        'description' => 'nullable|string',
        'is_band' => 'nullable|string',
    ]);

    $artist = Artist::find($id);

    if (!$artist) {
        return response()->json(['message' => 'Not found!'], 404);
    }

    $artist->update($request->all());

    return response()->json(['artist' => $artist]);
}


    /**
     * @api {delete} http://localhost:8000/api/artist/:id Delete an artist
     * @apiName DeleteArtist
     * @apiGroup Artist
     *
     * @apiParam {Number} id Artist unique ID.
     *
     * @apiSuccess {String} message Success message.
     * @apiSuccess {Number} id Deleted artist ID.
     *
     * @apiSuccessExample {json} Success Response:
     * HTTP/1.1 200 OK
     * {
     *   "message": "Product deleted successfully",
     *   "id": 2
     * }
     */
    public function destroy($id)
    {
        $artist = Artist::find($id);

        if (!$artist) {
            return response()->json(['message' => 'Not found!'], 404);
        }

        $artist->delete();
        return response()->json(['message' => 'Artist deleted successfully', 'id' => $id], 410);
    }
}
