<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SearchController extends Controller
{
    public function index(){
        return view('search');
    }
    public function search(Request $request){
        $query = $request->get('query');
        $rank = $request->get('rank');

        $process = new Process(['python3', 'animequery.py', 'animedb', "$rank", "$query"]);
        $process->run();

        if ($process->isSuccessful()) {
            // Proses berhasil dijalankan
            $output = $process->getOutput();
            // Lakukan sesuatu dengan output
        } else {
            // Proses gagal dijalankan
            throw new ProcessFailedException($process);
            // $error = $process->getErrorOutput();
            // Lakukan sesuatu dengan pesan error
        }

        $list_data = array_filter(explode("\n",$output));
        
        $data = array();

        // foreach ($list_data as $book) {
        //     $dataj =  json_decode($book, true);
        //     array_push($data, '<div class="card p-2 mb-4 mx-3 col-sm-3" style="width: 14rem;">
        //     <img src="'. $dataj['img'] .'" class="card-img-top" alt="'. $dataj['judul'] . '">
        //     <div class="card-body">
        //         <h6 class="card-title">'. $dataj['judul'] . '</h6>
        //         <p class="card-text">'. implode(',', $dataj['genre']) . '</p>
        //         </div>
        //         <a href="#" class="btn btn-primary"data-bs-toggle="modal" data-bs-target="#anime">More</a>
        // </div>
        // ');
        // }
        // return response()->json($data);
        foreach ($list_data as $book) {
            $dataj =  json_decode($book, true);
            array_push($data, $dataj);
        }
        return response()->json($data);
    }
}
