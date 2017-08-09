@extends('layouts.app')
<script>
    function toggle(){
        document.getElementById('banner').classList.toggle('.slideUp')
    }
</script>

<style>
    #banner {

        height:200px;
        margin:0 auto;
        margin-top:3%;
        overflow:hidden;
        transition: all 2s ease-in-out;
    }
    #banner.slideUp {
        height:0;
    }
    .banner-header {
        background-color: #ee3636;
        border-radius: 5px;
        text-align: center;
        font: bold 100% "Open Sans Regular";
        color: white;

    }
    .banner-header img {
        margin: 2px;
        max-height: 30px;
    }
    .banner-body {
        background-color: #e8ebec;
        text-align: center;

    }
    .banner-body img{
        max-height: 70px;
        box-shadow: 2px 2px 5px rgba(0,0,0,0.5);
    }
    .slideUp {
        height: 0;
    }
</style>

@section('content')

    <div class="container-fluid" id="banner" >
        <div class="row">
            <div class="col-md-12 banner-header">
                <span>Витрина оборудования и материалов для сварки от</span>
                <img src="/img/tiberis.png">
                <button type="button"class="close" onclick="toggle()" >&times;</button>
            </div>
            <div class="banner-body">
                <div class="col-md-2">
                    <a href="#">
                        <img src="img/img.png"/>
                        <p>Полуавтоматические аппараты</p>
                    </a>
                </div>
                <div class="col-md-2">
                <img src="img/img.png"/>
            </div>
                <div class="col-md-2">
                <img src="img/img.png"/>
            </div>
                <div class="col-md-2">
                <img src="img/img.png"/>
            </div>
                <div class="col-md-2">
                <img src="img/img.png"/>
            </div>
                <div class="col-md-2">
                <span>Заявки и заказы</span>
                <span>+7 ()</span>
            </div>
            </div>
        </div>
    </div>
@endsection.

<script>
    function toggle(){
        document.getElementById('banner').classList.toggle('slideUp')
    }
</script>