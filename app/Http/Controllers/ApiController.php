<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/** 
*
* @OA\Info(title="API Genres of Deezer", version="1.0")
*
*@OA\Server(url="https://laravel-dep.herokuapp.com")
*/

class ApiController extends Controller
{
    /**
     * 
     * @OA\Get(
     *      path="/api/genre",
     *      summary="Inserta todos los generos encontrados en la api de DEEZER",
     *      @OA\Response(
     *          response=200,
     *          description="Los Generos fueron Guardados en la BD."
     *      ),
     *      @OA\Response(
     *          response="default",
     *          description="Ha ocurrido un error"
     *      )
     * )
     */
    public function getGenre(){
        $client = curl_init();
        curl_setopt($client, CURLOPT_URL, 'https://api.deezer.com/genre');
        curl_setopt($client, CURLOPT_HEADER, 0);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

        $content = json_decode(curl_exec($client));
        curl_close($client);

        foreach ($content->data as $genre) {
            $newGenre =new Genre();
            if(isset($genre->name) && isset($genre->id)){
                //echo $genre->id." ".$genre->name."<br>";
                $genreName = Genre::where('name', $genre->name)->first();
                if(!isset($genreName)){
                    $newGenre->name = $genre->name;
                }else{
                    echo "<h6>el valor ya existe: ".$genre->name."</h6>";
                }
            }
            if(isset($genre->picture)){
                //echo "<img src='".$genre->picture."'><br>";
                $genrePicture = Genre::where('picture', $genre->picture)->first();
                if(!isset($genrePicture)){
                    $newGenre->picture = $genre->picture;
                }else{
                    echo "<h6>el valor ya existe: ".$genre->picture."</h6>";
                }
            }
            if(!isset($genre->picture_small)){
                //echo "<img src='".$genre->picture_small."'><br>";
                $genrePictureSmall = Genre::where('picture_small', $genre->picture_small)->first();
                if(isset($genrePictureSmall)){
                    $newGenre->picture_small = $genre->picture_small;    
                }else{
                    echo "<h6>el valor ya existe: ".$genre->picture_small."</h6>";
                }
            }
            if(!isset($genre->picture_medium)){
                //echo "<img src='".$genre->picture_medium."'><br>";
                $genrePictureMedium = Genre::where('picture_medium', $genre->picture_medium)->first();
                if(isset($genrePictureMedium)){
                    
                    $newGenre->picture_medium = $genre->picture_medium;  
                }else{
                    echo "<h6>el valor ya existe: ".$genre->picture_medium."</h6>";
                }
            }
            if(!isset($genre->picture_big)){
                //echo "<img src='".$genre->picture_big."'><br>";
                $genrePictureBig = Genre::where('picture_big', $genre->picture_big)->first();
                if(isset($genrePictureBig)){
                    
                    $newGenre->picture_big = $genre->picture_big;   
                }else{
                    echo "<h6>el valor ya existe: ".$genre->picture_big."</h6>";
                }
            }
            if(!isset($genre->picture_xl)){
                //echo "<img src='".$genre->picture_xl."'><br>";
                $genrePictureXl = Genre::where('picture_xl', $genre->picture_xl)->first();
                if(isset($genrePictureXl)){
                    
                    $newGenre->picture_xl = $genre->picture_xl;
                }else{
                    echo "<h6>el valor ya existe: ".$genre->picture_xl."</h6>";
                }
            }
            
                //echo $genre->type."<br>";
                $newGenre->type = $genre->type;
            
            $newGenre->save();
        }
    }

    public function getOneArtist($id){
        $client = curl_init();
        curl_setopt($client, CURLOPT_URL, 'https://api.deezer.com/artist/'.$id);
        curl_setopt($client, CURLOPT_HEADER, 0);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

        $content = json_decode(curl_exec($client));
        curl_close($client);
        if(property_exists($content,"error")){
            echo "No existe ese Artista";
        }else{
            echo json_encode($content);
        }
        
    }

    public function getAllGenres(){
        $genres = DB::table('genres')->get();
        echo json_encode($genres);
    }

    public function getOneGenre($id){
        $genre = DB::table('genres')->where('id',$id)->first();
        if($genre == null){
            echo "El genero no existe";
        }else{
            echo json_encode($genre);
        }
    }
}
