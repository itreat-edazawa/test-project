<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;


class CsvDownloadController extends Controller
{
    public function PostDownloadCsv(Request $request){
        $posts = Post::all();
        $csvHeader = ['ポストID','タイトル','内容','いいね数','ポスト日','最終更新日','ユーザーID'];
        $csvData = $posts->toArray();

        $response = new StreamedResponse(function() use ($csvHeader,$csvData){
            $handle = fopen('php//output','w');
            fputcsv($handle,$csvHeader);

            foreach($csvData as $row){
                fputcsv($handle,$row);
            }

            fclosw($handle);
        },200,[
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="posts.csv"',
        ]);

        return $response;

    }
}
