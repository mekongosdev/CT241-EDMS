/*
$(function(){
    $('#infoDevice').on('click', 'a', function(){
	load_ajax($(this).attr('id'));
    })
});


function load_ajax(ID){
    $.ajax({
        url : "js/action.php",
        type : "post",
        dateType:"text",
        data : {
            id : ID
        },
    success : function (result){
	//alert(result); /*
	var kq = $.parseJSON(result);
	var FNAME = kq.fname;
	var LNAME = kq.lname;
	var MONEY = kq.money;
	var START_DAY = kq.start_day;
	var START_TIME = kq.start_time;
	var DATE_END = kq.date_end;
	if (DATE_END == null) {
		var END_DAY = " ";
		var END_TIME = " ";
	} else {
		var END_DAY = kq.end_day;
		var END_TIME = kq.end_time;
	}
	var DESP = kq.desp;
	if (DESP == null) {
		var DESP = " ";
	} else {
		var DESP = kq.desp;
	}
    $('#resultDebt').html("<b>Đối tác: </b>" + FNAME + " " + LNAME +
						  "<br /><b>Số tiền: </b>" + MONEY +
						  "<br /><b>Mượn ngày: </b>" + START_DAY +
						  "<br /><b>Lúc: </b>" + START_TIME +
						  "<br /><b>Trả ngày: </b>" + END_DAY +
						  "<br /><b>Lúc: </b>" + END_TIME +
						  "<br /><b>Ghi chú: </b>" + DESP);
	//
	}
 });
}


$(function(){
    $('#infoDevice').on('click', 'tr', function(){
	//alert($(this).attr('title'));
	alert($(this).html());
	//load_ajax_view($(this).attr('title'));
	//load_ajax($(this).html());
    })
});*/

/*Code mẫu
$(document).ready(function () {
        $('#tablethongke').DataTable( {
            "order": [[ 3, "desc" ]]
        } );
        $('input[class="col-md-1"]').click(function () {

            $.post("tet2016.take.php",
                {
    file-action//		datadev: this.id 	//file-html
                },
                function (data, status) {
                    $(".modal-body").html(data)
                });
            $("#modalThongBao").modal('show');

        });
    });
*/
// 
// $(document).ready(function () {
//         $('editDevice2').click(function () {
//
//             $.post("action.php",
//                 {
//                     id: this.id
//                 },
//                 function (data, status) {
//                     $(".modal-body").html(data)
//                 });
//             $("#modalThongBao").modal('show');
//
//         });
//     });
