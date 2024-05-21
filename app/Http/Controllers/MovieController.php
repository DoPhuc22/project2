<?php

namespace App\Http\Controllers;

use App\Models\Age;
use App\Models\Cast;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\MovieCast;
use App\Models\MovieGenre;
use App\Models\Screening;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    //ADMIN
    public function index(Request $request)
    {
        $movies = Movie::latest();
        if (!empty($request->get('keyword'))){
            $movies = $movies->where('title', 'like', '%'.$request->get('keyword').'%');
        }
        $movies = $movies->paginate(5);
        $genres = Genre::all();
        $movieGenres = MovieGenre::all();
        $casts = Cast::all();
        $movieCasts = MovieCast::all();
        return view('admin.movie_manager.index', [
            'movies' => $movies,
            'genres' => $genres,
            'movieGenres' => $movieGenres,
            'casts' => $casts,
            'movieCasts' => $movieCasts
        ]);
    }

    public function indexDetail($id, Request $request)
    {
        $data = [];
        $movieGenres = MovieGenre::all();
        $ages = Age::all();
        $genres = Genre::all();
        $casts = Cast::all();
        $movieCasts = MovieCast::all();
        $movie = Movie::find($id);
        if (empty($movie)){
            $request->session()->flash('error', 'Không tìm thấy phim');
            return redirect()->route('movie.index');
        }
        $data['movie'] = $movie;
        return view('admin.movie_manager.movie_details', [
            $data,
            'movieGenres' => $movieGenres,
            'movieCasts' => $movieCasts,
            'ages' => $ages,
            'movie' => $movie,
            'genres'=> $genres,
            'casts' => $casts
        ]);
//        $movieId = $movie->id;
//        $movieGenres =DB::table('movie_genres')
//            ->where('movie_id', '=', $movieId)
//            ->join('genres', 'movie_genres.genre_id', '=', 'genres.id')
//            ->get();
//        $age = Age::where('id', '=', $movie->age_id)->first();
//
//        return view('admin.movie_manager.movie_details', [
//            'movie' => $movie,
//            'age' => $age,
//            'movieGenres' => $movieGenres,
//        ]);
    }

    public function create()
    {
        $data = [];
        $genres = Genre::orderBy('name', 'ASC')->get();
        $ages = Age::orderBy('name', 'ASC')->get();
        $casts = Cast::orderBy('name', 'ASC')->get();
        $data['genres'] = $genres;
        $data['ages'] = $ages;
        $data['casts'] = $casts;

        return view('admin.movie_manager.create', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'director' => 'required',
            'duration' => 'required',
            'language' => 'required',
            'is_featured' => 'required|in:Yes,No',
            'release_date' => 'required',
            'genre_id' => 'required',
            'age_id' => 'required',
            'cast_id' => 'required',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()){
            $movie = new Movie();
            $movie->title = $request->title;
            $movie->director = $request->director;
            $movie->description = $request->description;
            $movie->is_featured = $request->is_featured;
            $movie->language = $request->language;
            $movie->duration = $request->duration;
            $movie->release_date = $request->release_date;
            $movie->age_id = $request->age_id;
            $movie->status = $request->status ;
            $movie->save();

           foreach($request->genre_id as $value){
               $i=0;
               $movieGenre = [
                   'movie_id'=> Movie::where('id', '=',Movie::max('id'))->first()->id,
                   'genre_id'=>  $value ?? '',
               ];
               MovieGenre::create($movieGenre);
           }

            foreach($request->cast_id as $value){
                $i=0;
                $movieCast = [
                    'movie_id'=> Movie::where('id', '=',Movie::max('id'))->first()->id,
                    'cast_id'=>  $value ?? '',
                ];
                MovieCast::create($movieCast);
            }

//             Save Image Here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $movie->id.'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/movie/'.$newImageName;
                File::copy($sPath, $dPath);

                // Generate Image Thumbnail
//                $dPath = public_path().'/uploads/movie/thumb/'.$newImageName;
//                $img = Image::make($sPath);
//                $img->resize(450, 600);
//                $img->save($dPath);

                $movie->image = $newImageName;
                $movie->save();
            }

            $request->session()->flash('success', 'Đã thêm phim thành công');
            return response()->json([
                'status' => true,
                'message' => 'Đã thêm phim thành công'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($id, Request $request)
    {
        $data = [];

        $genres = Genre::orderBy('name', 'ASC')->get();
        $ages = Age::orderBy('name', 'ASC')->get();
        $casts = Cast::orderBy('name', 'ASC')->get();
        $data['genres'] = $genres;
        $data['ages'] = $ages;
        $data['casts'] = $casts;
        $movie = Movie::find($id);
        if (empty($movie)){
            $request->session()->flash('error', 'Không tìm thấy phim');
            return redirect()->route('movie.index');
        }
        $data['movie'] = $movie;
        return view('admin.movie_manager.edit', $data);
    }

    public function update($id, Request $request)
    {

        $movie = Movie::find($id);
        if (empty($movie)){
            $request->session()->flash('error', 'Không tìm thấy phim');

            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Không tìm thấy phim'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'director' => 'required',
            'duration' => 'required',
//            'description' => 'required',
            'is_featured' => 'required',
            'language' => 'required',
            'release_date' => 'required',
            'age_id' => 'required',
            'status' => 'required'

        ]);
        if ($validator->passes()){
            $movie->title = $request->title;
            $movie->director = $request->director;
            $movie->description = $request->description;
            $movie->is_featured = $request->is_featured;
            $movie->duration = $request->duration;
            $movie->language = $request->language;
            $movie->release_date = $request->release_date;
            $movie->age_id = $request->age_id;
            $movie->status = $request->status ;
            $movie->save();
            $oldImage = $movie->image;

            $genresArray = [];
            $movies = Movie::where('status', 1);
            $movieGenres = MovieGenre::
            join('movies', 'movie_genres.movie_id', 'movies.id')->orderBy('movie_genres.genre_id', 'DESC')->where('movies.status', 1)
                ->get();
//            if (!empty($request->get('genre'))){
//                $genresArray = explode(',', $request->get('genre'));
//                $movieGenres = $movies->whereIn('genre_id', $genresArray)->join('movie_genres', 'movie_genres.movie_id', 'movies.id')->where('movies.status', 1);
//            }
//            foreach($request->genre_id as $value){
//                $i=0;
//                $movieGenre = [
//                    'movie_id'=> Movie::where('id', '=',Movie::max('id'))->first()->id,
//                    'genre_id'=>  $value ?? '',
//                ];
//                MovieGenre::create($movieGenre);
//            }
//            foreach($request->cast_id as $value){
//                $i=0;
//                $movieCast = [
//                    'movie_id'=> Movie::where('id', '=',Movie::max('id'))->first()->id,
//                    'cast_id'=>  $value ?? '',
//                ];
//                MovieCast::create($movieCast);
//            }

            //             Save Image Here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $movie->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/movie/'.$newImageName;
                File::copy($sPath, $dPath);

                // Generate Image Thumbnail
//                $dPath = public_path().'/uploads/movie/thumb/'.$newImageName;
//                $img = Image::make($sPath);
//                $img->resize(450, 600);
//                $img->save($dPath);

                $movie->image = $newImageName;
                $movie->save();

                // DELETE old image here
                File::delete(public_path().'/temp/'.$oldImage);
                File::delete(public_path().'/uploads/movie/'.$oldImage);
            }

            $request->session()->flash('success', 'Đã cập nhật thông tin phim thành công');
            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhật thông tin phim thành công'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($id, Request $request)
    {
        $movie = Movie::find($id);
        if (empty($movie)){
            $request->session()->flash('error', 'Không tìm thấy phim');
            return response()->json([
                'status' => true,
                'message' => 'Không tìm thấy phim'
            ]);
        }
//        $movieCasts = MovieCast::where('cast_id', $id)->get();
//        if (!empty($movieCasts)){
//            MovieCast::where('cast_id', $id)->delete();
//        }
//        $movieGenres = MovieGenre::where('genre_id', $id)->get();
//        if (!empty($movieGenres)){
//            MovieGenre::where('genre_id', $id)->delete();
//        }

        File::delete(public_path().'/temp/'.$movie->image);
        File::delete(public_path().'/uploads/movie/'.$movie->image);

        $movie->delete();
        $request->session()->flash('success', 'Đã xóa phim thành công');
        return response()->json([
            'status' => true,
            'message' => 'Đã xóa phim thành công'
        ]);
    }



    // ============================CUSTOMER===================================
    public function show(Request $request, $movieAge = null)
    {
        $ageSelected = '';
        $genresArray = [];

        $genres = Genre::orderBy('name', 'ASC')->where('status', 1)->get();
        $ages = Age::orderBy('name', 'ASC')->get();
        $casts = Cast::orderBy('name', 'ASC')->where('status', 1)->get();
        $movies = Movie::where('status', 1);

        $movieGenres = Movie::
            join('movie_genres', 'movie_genres.movie_id', 'movies.id')->orderBy('movie_genres.genre_id', 'DESC')->where('movies.status', 1)
            ->get();

//        $movieGenres = MovieGenre::all();

        //Filter
        if (!empty($movieAge)){
            $age = Age::where('name', $movieAge)->first();
            $movies = $movies->where('age_id', $age->id);
            $ageSelected = $age->id;
        }
        if (!empty($request->get('genre'))){
            $genresArray = explode(',', $request->get('genre'));
            $movieGenres = $movies->whereIn('genre_id', $genresArray)->join('movie_genres', 'movie_genres.movie_id', 'movies.id')->where('movies.status', 1);
        }

        if (!empty($request->get('search'))){
            $movies = $movies->where('title', 'like', '%'.$request->get('search').'%');
        }

        if ($request->get('sort') != ''){
            if ($request->get('sort') == 'newest'){
                $movies = $movies->orderBy('id', 'DESC');
            }elseif ($request->get('sort') == 'oldest') {
                $movies = $movies->orderBy('id', 'ASC');
            }
        }else{
            $movies = $movies->orderBy('id', 'DESC');
        }
        $movies = $movies->get();

//        $movies = Movie::paginate(6);
        $data['genres'] = $genres;
        $data['ages'] = $ages;
        $data['casts'] = $casts;
        $data['movies'] = $movies;
        $data['movieGenres'] = $movieGenres;
        $data['genresArray'] = $genresArray;
        $data['ageSelected'] = $ageSelected;
        $data['sort'] = $request->get('sort');
        return view('customer.movie.index', $data);
    }

    public function bookTickets($id, Request $request)
    {
        $data = [];
        $movieGenres = MovieGenre::all();
        $ages = Age::all();
        $genres = Genre::all();
        $casts = Cast::all();
        $movieCasts = MovieCast::all();
        $movie = Movie::find($id);
        if (empty($movie)){
            $request->session()->flash('error', 'Không tìm thấy phim');
            return redirect()->route('movie');
        }
        $data['movie'] = $movie;
        $screenings = Screening::all()->where('movie_id','=',$movie->id);
        return view('customer.book_ticket.choosingScreening', [
            $data,
            'movieGenres' => $movieGenres,
            'movieCasts' => $movieCasts,
            'ages' => $ages,
            'movie' => $movie,
            'genres'=> $genres,
            'casts' => $casts,
            'screenings' => $screenings
        ]);
    }
    public function bookScreening($id, Request $request)
    {
        $data = [];
        $movieGenres = MovieGenre::all();
        $ages = Age::all();
        $genres = Genre::all();
        $casts = Cast::all();
        $movieCasts = MovieCast::all();
        $movie = Movie::find($id);
        if (empty($movie)){
            $request->session()->flash('error', 'Không tìm thấy phim');
            return redirect()->route('movie');
        }
        $data['movie'] = $movie;
        $screenings = Screening::all()->where('movie_id','=',$movie->id);
        return view('customer.book_ticket.choosingScreening', [
            $data,
            'movieGenres' => $movieGenres,
            'movieCasts' => $movieCasts,
            'ages' => $ages,
            'movie' => $movie,
            'genres'=> $genres,
            'casts' => $casts,
            'screenings' => $screenings
        ]);
    }

    public function showDetails(Movie $movie)
    {
        $ages = Age::where('id', '=', $movie->age_id)->first();
        $genres = Genre::all();
        $movieGenres = MovieGenre::all();
        $casts = Cast::all();
        $movieCasts = MovieCast::all();
        $data['genres'] = $genres;
        $data['ages'] = $ages;
        $data['casts'] = $casts;
        $data['movie'] = $movie;
        $data['movieGenres'] = $movieGenres;
        $data['movieCasts'] = $movieCasts;
        return view('customer.movie.movie-details', $data);
    }
}
