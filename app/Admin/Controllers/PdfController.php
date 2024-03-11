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
       //$guidRecord = Rapport::find(1);

        
        // Define the date range
        $startDate = Carbon::parse($guidRecord->startDate);

        $endDate = Carbon::parse($guidRecord->endDate);

        \Log::info('Start date', ['start_date' => $guidRecord->startDate]);
        \Log::info('End date', ['end_date' => $guidRecord->endDate]);
        // Start the query without the creator_id and category_id condition
        $query = Recipe::whereBetween('created_at', [$startDate, $endDate]);
      

        // Conditionally add the creator_id condition if needed
        if ($guidRecord->creator_id) {
            $query->where('creator_id', $guidRecord->creator_id);
        }

        // Conditionally add the category_id condition if needed
        if ($guidRecord->category_id) {
            $query->where('category_id', $guidRecord->category_id);
        }

        $recipes = $query->get();

        // $ids = $query->pluck('id');
        // foreach ($ids as $id) {
        //     Log::info('My ids', [ 'id' => $id]);
        // }

        Log::info('My form', [
            'recipes' => $recipes]);

         $data = collect();
        
        foreach ($recipes as $recipe) {
            $data->push(['quantity' => $recipe['id'], 'description' => $recipe['description'], 'price' => $recipe['title'],'category' => ['category'], 'creator_id' => ['creator_id']]);
        }

        // $data = [
        //     [
        //         'quantity' => 1,
        //         'description' => '1 Year Subscription',
        //         'price' => '129.00'
        //     ]
        // ];
    
        $pdf = Pdf::loadView('pdf', ['data' => $data]);
        return $pdf->stream('invoice.pdf');
    }
}
