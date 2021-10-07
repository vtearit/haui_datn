@extends('frontend.layouts.index')
@section('css')
<link href="frontend/css/sweetalert.css" rel="stylesheet">
@endsection
@section('content')
<section>
    <div class="container">
        <div class="row">


            <div class="col-sm-12">
                <div class="product-details" id="product-details">
                    <!--product-details-->
                    <form>
                        @csrf
                        <input type="hidden" name="gp_id" value="{{$group_product->id}}" />
                        <input type="hidden" name="ram" value="{{$selected_product->configuration->ram}}" />
                        <input type="hidden" name="color" value="{{$selected_product->configuration->color}}" />

                    </form>

                </div>
                <!--/product-details-->



            </div>
        </div>
    </div>

</section>

@endsection

@section('script')
<script src="frontend/js/sweetalert.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        loadProduct();
        function loadComment() {
            var token = $('input[name="_token"]').val();
            var gp_id = $('.gp_id').val();
            //alert(token);
            $.ajax({
                method: 'POST',
                url: 'tat-ca-binh-luan',
                data: {
                    id: gp_id,
                    _token: token
                },
                success: function(data) {
                    $('#loadComment').html(data);
                    $('.post-comment').click(function() {
                        var comment = $('.comment').val();
                        var gp_id = $('.gp_id').val();
                        var token = $('input[name="_token"]').val();
                        if (comment == "") {
                            swal("Không được bỏ trống", "", "error");
                        } else {
                            $.ajax({
                                method: 'POST',
                                url: 'binh-luan',
                                data: {
                                    comment: comment,
                                    gp_id: gp_id,
                                    _token: token
                                },
                                success: function(data) {
                                    loadComment();
                                    // alert(data);
                                },
                                error: function(data) {
                                    //console.log(data);
                                    alert(data);
                                }
                            });
                        }
                    });

                    $(".cm_update").click(function() {
                        var id = parseInt($(this).data('id_cm'));
                        var token = $('input[name="_token"]').val();
                        $.ajax({
                            method: 'POST',
                            url: 'sua-binh-luan',
                            data: {
                                id: id,
                                _token: token
                            },
                            success: function(data) {
                                $('#' + id).html(data);

                                $(".cm_update").click(function() {
                                    // alert('ok');
                                    var id = parseInt($(this).data('id_cm'));
                                    var comment = $('.comment_edit').val();
                                    var token = $('input[name="_token"]').val();
                                    if (comment == "") {
                                        swal("Không được bỏ trống", "", "error");
                                    } else {
                                        $.ajax({
                                            method: 'POST',
                                            url: 'hoan-thanh-sua-binh-luan',
                                            data: {
                                                comment: comment,
                                                id: id,
                                                _token: token
                                            },
                                            success: function(data) {
                                                loadComment();
                                                // alert(data);
                                            },
                                            error: function(data) {
                                                //console.log(data);
                                                alert(data);
                                            }
                                        });

                                    }
                                });
                                $(".cm_cancel").click(function() {
                                    loadComment();
                                });
                            }

                        });


                    });

                    $(".cm_delete").click(function() {
                        var id = parseInt($(this).data('id_cm'));
                        var token = $('input[name="_token"]').val();
                        swal({
                                title: "Bạn có chắc chắn xóa bình luận này không?",
                                showCancelButton: true,
                                cancelButtonText: "Hủy",
                                cancelButtonClass: "btn-danger",
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "Xóa",
                                closeOnConfirm: true
                            },
                            function() {
                                $.ajax({
                                    method: 'POST',
                                    url: 'xoa-binh-luan',
                                    data: {
                                        id: id,
                                        _token: token
                                    },
                                    success: function(data) {
                                        loadComment();
                                    },
                                    error: function(data) {
                                        alert(data);
                                    }
                                });
                            });
                    });

                },
                error: function(data) {

                }
            });
        }


        function loadProduct() {
            var token = $('input[name="_token"]').val();
            var gp_id = $('input[name="gp_id"]').val();
            var ram = $('input[name="ram"]').val();
            var color = $('input[name="color"]').val();
            $.ajax({
                method: 'POST',
                url: 'tat-ca-san-pham',
                data: {
                    gp_id: gp_id,
                    ram: ram,
                    color: color,
                    _token: token
                },
                success: function(data) {
                    $('#product-details').html(data);
                    loadComment();
                    $('.color').click(function() {
                        var color = $('.color:checked').val();
                        var ram = $('.ram:checked').val();
                        var token = $('input[name="_token"]').val();
                        var gp_id = $('input[name="gp_id"]').val();
                        $.ajax({
                            method: 'POST',
                            url: 'thay-doi-san-pham',
                            data: {
                                color: color,
                                ram: ram,
                                gp_id: gp_id,
                                _token: token
                            },
                            success: function(data) {
                                if (data == 0)
                                    alert('Sản phẩm rỗng');
                                else {
                                    $('#product-details').html(data);
                                    loadProduct();
                                }


                            }
                        });
                    });
                    $('.ram').click(function() {
                        var color = $('.color:checked').val();
                        var ram = $('.ram:checked').val();
                        var token = $('input[name="_token"]').val();
                        var gp_id = $('input[name="gp_id"]').val();
                        //alert(ram);
                        $.ajax({
                            method: 'POST',
                            url: 'thay-doi-san-pham',
                            data: {
                                color: color,
                                ram: ram,
                                gp_id: gp_id,
                                _token: token
                            },
                            success: function(data) {
                                if (data == 0)
                                    alert('Sản phẩm rỗng');
                                else {
                                    $('#product-details').html(data);
                                    loadProduct();
                                }
                            }
                        });
                    });
                    $('.add-to-cart').click(function() {
                        var id = $('.product_id').val();
                        var product_name = $('.product_name').val();
                        var product_image = $('.product_image').val();
                        var product_price = $('.product_price').val();
                        var product_qty = $('.product_qty').val();
                        var token = $('input[name="_token"]').val();
                        // swal("Hello world!");
                        //alert(id);

                        $.ajax({
                            method: 'POST',
                            url: 'them-gio-hang',
                            data: {
                                product_id: id,
                                product_name: product_name,
                                product_image: product_image,
                                product_price: product_price,
                                product_qty: product_qty,
                                _token: token
                            },
                            success: function() {
                                swal({
                                        title: "Đã thêm sản phẩm vào giỏ hàng",

                                        showCancelButton: true,
                                        cancelButtonText: "Xem tiếp",
                                        cancelButtonClass: "btn-danger",
                                        confirmButtonClass: "btn-success",
                                        confirmButtonText: "Đi đến giỏ hàng",
                                        closeOnConfirm: false
                                    },
                                    function() {
                                        window.location.href = "{{url('/gio-hang')}}";
                                    });

                            }

                        });

                    });
                }
            });
        }


    });
</script>

@endsection