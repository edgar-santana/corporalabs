$(document).ready(function(){
    $('i.fa-trash').click(function(e){
        if(confirm("Are you sure?") == false){
            e.preventDefault();
        }
    });

    $('.cost-component').change(function(){
        var cost_result = parseFloat($('#client_order_product').children(':selected').data('price')) * parseInt($('#client_order_amount').val());
        $('#client_order_cost').val(cost_result);
    });

    $('.order-list-table').DataTable({
        responsive: true,
        "columnDefs": [
            { "className": "text-right", "targets": [-2, -3] },
            { "className": "text-right", "targets": [-1], "orderable": false },
            { "className": "text-left", "targets": "_all" }            
        ]
    });
    $('.product-list-table').DataTable({
        responsive: true,
        "columnDefs": [
            { "className": "text-right", "targets": [-2] },
            { "className": "text-right", "targets": [-1], "orderable": false },
            { "className": "text-left", "targets": "_all" }            
        ]
    });
    $('.client-list-table').DataTable({
        responsive: true,
        "columnDefs": [
            { "className": "text-right", "targets": [-1], "orderable": false },
            { "className": "text-left", "targets": "_all" }            
        ]
    });    
});
