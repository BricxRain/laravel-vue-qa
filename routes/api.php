<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('/token', 'Auth\LoginController@getToken');
Route::post('/register', 'Api\Auth\RegisterController');
Route::post('/login', 'Api\Auth\LoginController@store');

Route::get('/questions/{question}-{slug}', 'Api\QuestionDetailsController');

Route::middleware(['auth:api'])->group(function() {
    Route::delete('/logout', 'Api\Auth\LoginController@destroy');

    Route::apiResource('questions', 'Api\QuestionsController')->except(['index']);
    Route::apiResource('questions.answers', 'Api\AnswersController')->except(['index']);

    Route::post('/questions/{question}/vote', 'Api\VoteQuestionController')->name('question.vote');
    Route::post('/answers/{answer}/vote', 'Api\VoteAnswerController')->name('answer.vote');

    Route::post('/answers/{answer}/accept', 'Api\AcceptAnswerController')->name('answer.accept');
    Route::post('/questions/{question}/favorites', 'Api\FavoritesController@store')->name('question.favorite');
    Route::delete('/questions/{question}/favorites', 'Api\FavoritesController@destroy')->name('question.unfavorite');

    Route::get('/my-posts', 'Api\MyPostsController');
});
    
Route::get('/questions', 'Api\QuestionsController@index')->name('questions.index');
Route::get('/questions/{question}/answers', 'Api\AnswersController@index')->name('questions.answers.index');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
