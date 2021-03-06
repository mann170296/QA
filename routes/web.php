<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'QuestionsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/questions', 'QuestionsController')->except('show');

Route::resource('questions.answers', 'AnswersController')->except(['index', 'show', 'create']);

Route::get('/questions/{question:slug}', 'QuestionsController@show')->name('questions.show');

Route::post('/answers/{answer}/accept', 'AnswersController@accept')->name('answer.accept');

Route::post('/questions/{question}/vote', 'QuestionsController@vote')->name('question.vote')->middleware(['auth']);

Route::post('/answers/{answer}/vote', 'AnswersController@vote')->name('answer.vote')->middleware(['auth']);