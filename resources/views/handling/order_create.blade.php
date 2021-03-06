@extends('layouts.app')

@section('template')

<style>
card {
    display: block;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
    border-radius: 20px;
    transition: .2s ease-out .0s;
    color: #7a8e97;
    background: #fff;
    padding: 0;
    position: relative;
    border: 1px solid rgba(0, 0, 0, 0.15);
    margin-bottom: 2rem;
}
statistic{
    display: block;
}
card:hover {
    box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 100px;
}
badge{
    display: inline-block;
    padding: 0.25rem 0.75em;
    font-weight: 700;
    line-height: 1.5;
    text-align: center;
    vertical-align: baseline;
    border-radius: 0.125rem;
    background-color: #f5f5f5;
    margin: 1rem;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
    transition: .2s ease-out .0s;
    color: #7a8e97;
    position: relative;
    border: 1px solid rgba(0, 0, 0, 0.15);
    cursor: pointer;
}
.atsast-empty{
    justify-content: center;
    align-items: center;
    height: 10rem;
}
/* 这是展示物品的通用card 样式 */
card.item-card {
    overflow: hidden;
}
card.item-card > div{
    padding: 0;
    text-align: center;
}
a.card-link{
    padding:0;
}
.mhs-item-img {
    object-fit: cover;
}
.mhs-button {
    border-radius: 5px;
    padding:0.3rem 0.3rem;
    line-height:2;
}
.mhs-button-count {
    font-size: larger;
    padding:0.3rem 0.3rem;
    line-height:2;
}
.mhs-item-text {
    margin: 0.1rem;
}
/* ======= */
/* 这是订单、购物车用的card 样式*/
card.order-card {
    margin-bottom: 0.5rem;
}
card.order-card > div {
    padding: 0;
}
.mhs-item-img-order {
    border-radius: 20px !important;
    max-width: 10rem;
    max-height: 10rem;
    object-fit: cover;
}
.mhs-button-cart {
    border-radius: 20px;
}
.mhs-item-img-detailed {
    border-radius: 20px !important;
    max-width: 20rem;
    max-height: 20rem;
    object-fit: cover;
}
.mhs-item-img-review {
    border-radius: 20px !important;
    max-width: 5rem;
    max-height: 5rem;
    object-fit: cover;
}
/* 来自mdui 的FAB */
.mdui-fab-fixed{
    position: fixed !important;
}
@media (min-width: 1px) {
    .mdui-fab-fixed{
        position: fixed !important;
        right: 16px;
        bottom: 16px;
    }
}
@media (min-width: 1024px) {
    .mdui-fab-fixed{
        position: fixed !important;
        right: 24px;
        bottom: 24px;
    }
}
</style>

<style>

    card.mhs-card > div{
        text-align: center;
        padding: 0.5rem;
    }

    .mhs-item-img-order-create {
        border-radius: 20px !important;
        max-width: 8rem;
        max-height: 8rem;
        object-fit: cover;
    }
    avatar{
        display: block;
        position: relative;
        text-align: center;
        height: 2.5rem;
    }
    avatar > img{
        display: block;
        width:2.5rem;
        height:2.5rem;
        border-radius: 2000px;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        top:0%;
        left:0;
        right:0;
        margin: auto;
    }
    .top-fc{
        position: relative;
        top: -1rem;
    }
    .wb {
        word-break:break-all;
    }
    .mb-user{
        margin-bottom: 2.5rem;
    }
</style>


<div class="container mundb-standard-container">
    <h3 class="mhs-title mb-3 mt-3">创建订单</h3>
        <card class="p-1">
            @foreach($items as $q)
            <div class="media item m-3" iid="{{$q->iid}}" count="{{$q->order_count_}}">
                <figure class="figure">
                    <img class="align-self-center mhs-item-img-order-create figure-img img-fluid mb-0" src="{{$ATSAST_DOMAIN.$q->pic}}">
                    <figcaption class="figure-caption text-right top-fc"><span class="badge badge-pill badge-primary">X {{$q->order_count_}}</span></figcaption>
                </figure>
                <div class="media-body ml-3">
                    <h4 class="mt-0 wb"><a href="{{$ATSAST_DOMAIN}}/handling/item/detail/{{$q->iid}}">{{$q->name}}</a></h4>
                    <i class="MDI sitemap"></i>位置：{{$q->location}}
                </div>
            </div>
            @endforeach
        </card>
    <h5 class="mt-3 text-primary">总计：{{$total_item}} 件物品，共 {{$total_count}} 个。</h5>
    <br>
    </div>
    <button type="button" class="btn btn-success bmd-btn-fab mdui-fab-fixed active" onclick="submit()"><i class="MDI clipboard-check"></i></button>

    <script>
        function submit(){
            NodeList.prototype.map=Array.prototype.map;
            document.querySelectorAll('.item').map(function(val,index,arr){
                let iid=val.getAttribute('iid');
                let count=val.getAttribute('count');
                $.ajax({
                    type: 'POST',
                    url: '{{$ATSAST_DOMAIN}}/ajax/handling/createOrder',
                    data: {
                        iid:iid,
                        count:count
                    },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }, success: function(ret){
                        console.log(ret);
                        alert(ret.desc);
                        setTimeout(function(){
                            location.href="{{$ATSAST_DOMAIN}}/handling/order";
                        }, 1000);
                    }, error: function(xhr, type){
                        console.log(xhr);
                        switch(xhr.status) {
                            case 422:
                                alert(xhr.responseJSON.errors[Object.keys(xhr.responseJSON.errors)[0]][0], xhr.responseJSON.message);
                                break;
                            case 429:
                                alert(`您的操作过于频繁，请 ${xhr.getResponseHeader('Retry-After')} 秒后再试。`);
                                break;
                            default:
                                alert("Server Connection Error");
                        }
                    }
                });
            });
        }
    </script>
@endsection
