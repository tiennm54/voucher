<?php

Route::group(['prefix' => '', 'namespace' => 'Modules\Articles\Http\Controllers'], function()
{
    Route::get('/',['as'=>'frontend.articles.index','uses'=>'ArticlesController@index']);
    Route::get('list-product.html',['as'=>'frontend.articles.getListProduct','uses'=>'ArticlesController@getListProduct']);
    Route::get('premium-key-reseller-{id?}/{url?}',['as'=>'frontend.articles.pricing','uses'=>'ArticlesController@pricing']);
    Route::get('premium-key-view-{id?}/{url?}',['as'=>'frontend.articles.view','uses'=>'ArticlesDetailController@view']);
    Route::get('premium-key-reseller/search',['as'=>'frontend.articles.getSearch','uses'=>'ArticlesController@getSearch']);
    Route::post('product/reviewProduct',['as'=>'frontend.articles.reviewProduct','uses'=>'ArticlesDetailController@reviewProduct']);
});


Route::group(['prefix' => 'shoppingCart', 'namespace' => 'Modules\Articles\Http\Controllers'], function()
{
    Route::post('addToCart',['as'=>'frontend.shoppingCart.addToCart','uses'=>'ShoppingCartController@addToCart']);
    Route::post('deleteSessionOrder',['as'=>'frontend.shoppingCart.deleteSessionOrder','uses'=>'ShoppingCartController@deleteSessionOrder']);
    Route::post('changeNumberProductOrder',['as'=>'frontend.shoppingCart.changeNumberProductOrder','uses'=>'ShoppingCartController@changeNumberProductOrder']);
    Route::post('viewCartModal',['as'=>'frontend.shoppingCart.viewCartModal','uses'=>'ShoppingCartController@viewCartModal']);
    Route::post('emptyCart',['as'=>'frontend.shoppingCart.emptyCart','uses'=>'ShoppingCartController@emptyCart']);
});

Route::group(['prefix' => 'onestepcheckout', 'namespace' => 'Modules\Articles\Http\Controllers'], function(){
    Route::get('{id}-{code?}',['as'=>'frontend.shoppingCart.buyNow','uses'=>'ShoppingCartController@buyNow']);
});
        
Route::group(['prefix' => 'checkout', 'namespace' => 'Modules\Articles\Http\Controllers'], function()
{
    Route::get('index.html',['as'=>'frontend.checkout.index','uses'=>'CheckoutController@index']);
    Route::post('selectTypePayment',['as'=>'frontend.checkout.selectTypePayment','uses'=>'CheckoutController@selectTypePayment']);
    Route::post('changeQuantity',['as'=>'frontend.checkout.changeQuantity','uses'=>'CheckoutController@changeQuantity']);
    Route::post('deleteProductCheckout',['as'=>'frontend.checkout.deleteProductCheckout','uses'=>'CheckoutController@deleteProductCheckout']);
    Route::post('chooseBonusMoney',['as'=>'frontend.checkout.chooseBonusMoney','uses'=>'CheckoutController@chooseBonusMoney']);
    Route::post('confirmOrder',['as'=>'frontend.checkout.confirmOrder','uses'=>'CheckoutController@confirmOrder']);
    Route::get('confirmOrder',['as'=>'frontend.checkout.getConfirmOrder','uses'=>'CheckoutController@getConfirmOrder']);
    Route::get('success/{email?}/{password?}',['as'=>'frontend.checkout.success','uses'=>'CheckoutController@checkoutSuccess']);
    Route::get('sendMail',['as'=>'frontend.checkout.sendMail','uses'=>'CheckoutController@sendMail']);
    Route::post('createOrderVisa',['as'=>'frontend.checkout.createOrderVisa','uses'=>'CheckoutController@createOrderVisa']);
});


Route::group(['prefix' => '', 'namespace' => 'Modules\Articles\Http\Controllers'], function() {
    Route::get('information-view-{id?}/{url?}',['as'=>'frontend.information.view','uses'=>'InformationClientController@view']);
});


Route::group(['prefix' => 'sitemap', 'namespace' => 'Modules\Articles\Http\Controllers'], function() {
    Route::get('site-map.xml',['as'=>'frontend.sitemap.index','uses'=>'SiteMapController@index']);
});

Route::group(['prefix' => 'checkout-visa', 'namespace' => 'Modules\Articles\Http\Controllers'], function() {
    Route::get('success',['as'=>'frontend.checkoutVisa.success','uses'=>'VisaController@checkoutSuccess']);
    Route::get('failure',['as'=>'frontend.checkoutVisa.failure','uses'=>'VisaController@checkoutFailure']);
    Route::post('callback',['as'=>'frontend.checkoutVisa.callback','uses'=>'VisaController@checkoutCallback']);
    Route::get('callback',['as'=>'frontend.checkoutVisa.getCallback','uses'=>'VisaController@getCallback']);
});


Route::group(['prefix' => 'invoice', 'namespace' => 'Modules\Articles\Http\Controllers'], function() {
    Route::get('view/{id}/{email}',['as'=>'frontend.invoice.view','uses'=>'InvoiceController@view']);
});