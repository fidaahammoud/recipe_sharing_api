<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use OpenAdmin\Admin\Admin;
use OpenAdmin\Admin\Controllers\Dashboard;
use OpenAdmin\Admin\Layout\Column;
use OpenAdmin\Admin\Layout\Content;
use OpenAdmin\Admin\Layout\Row;
use Carbon\Carbon;
use App\Models\Rapport;
use App\Models\Recipe;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    public function index(Request $request) {
        $guid = $request->get('guid');
        Log::info('My form', [
            'guid' =>  $guid]);

       $guidRecord = DB::table('rapports')->where('guid', $guid)->first();

        
        $startDate = Carbon::parse($guidRecord->startDate);

        $endDate = Carbon::parse($guidRecord->endDate);

        \Log::info('Start date', ['start_date' => $guidRecord->startDate]);
        \Log::info('End date', ['end_date' => $guidRecord->endDate]);

        $query = Recipe::whereBetween('created_at', [$startDate, $endDate]);
      

        if ($guidRecord->creator_id) {
            $query->where('creator_id', $guidRecord->creator_id);
        }

        if ($guidRecord->category_id) {
            $query->where('category_id', $guidRecord->category_id);
        }

        $recipes = $query->get();

        Log::info('My form', [
            'recipes' => $recipes]);

         $data = collect();
        
         foreach ($recipes as $recipe) {

            $recipe->load('category', 'ingredients', 'steps', 'user', 'comments.user.images', 'images');


            $data->push([
                'recipeId' => $recipe->id,
                'description' => $recipe->description,
                'title' => $recipe->title,
                'category' =>$recipe->category->name,
                'creator' => $recipe->user->name,
            ]);
        }

       
    
        $pdf = Pdf::loadView('pdf', ['data' => $data, 'reportId' => $guidRecord->id, 'createdAt' => $guidRecord->created_at]);

        return $pdf->stream('invoice.pdf');
    }
}
