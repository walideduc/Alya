/**
 * Created by walid on 25/11/15.
 */

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#addForm').submit(function(){
        var quantityToAdd = $('#quantityToAdd').val();
        var product_id = $('#product_id').val() ;
        $.ajax({
            type: "POST",
            url: "/cart/add",
            data: { quantityToAdd: quantityToAdd, product_id: product_id },
            success:function(data){
                console.log(data);
            }
        });
    });
});
