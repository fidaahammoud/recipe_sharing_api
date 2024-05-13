<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Yumssterr</title>
    <link rel="stylesheet" href="{{ asset('pdf.css') }}" type="text/css"> 
</head>
<body>
    <table class="w-full">
        <tr>
            <td class="w-half">
                <img src="{{ asset('storage/logo.jpeg') }}" alt="laravel daily" width="200" />
            </td>
            <td class="w-half">
            <h2>Report ID: {{ $reportId }}</h2>
            </td>
        </tr>
    </table>
 
    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div><h4>Date:</h4></div>
                    <div><h5> {{ $createdAt }}</h5></div>
                </td>
               
            </tr>
        </table>
    </div>
 
    <div class="margin-top">
        <table class="products">
            <tr>
                <th>RecipeId</th>
                <th>Title</th>
                <th>Description</th>
                <th>CategoryName</th>
                <th>CreatorName</th>
            </tr>
            <tr class="products">
            @foreach($data as $item)
                <tr> 
                    <td>
                        {{ $item['recipeId'] }}
                    </td>
                    <td>
                        {{ $item['title'] }}
                    </td>
                    <td>
                        {{ $item['description'] }}
                    </td>
                    <td>
                        {{ $item['category'] }}
                    </td>
                    <td>
                        {{ $item['creator'] }}
                    </td>
                </tr> 
            @endforeach
            </tr>
        </table>
    </div>
 
    <div class="total">
         Total Recipes : {{ $data->count() }}
    </div>
 
    <div class="footer margin-top">
        <div>Thank you</div>
        <div>&copy; Yumssterr</div>
    </div>
</body>
</html>