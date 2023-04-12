@extends('layouts.errors')

@section('title', translate('Internal Server Error'))
@section('code', '500')
@section('message', translate('Oops… You just found an error page'))
@section('message2', translate('We are sorry but our server encountered an internal error'))

