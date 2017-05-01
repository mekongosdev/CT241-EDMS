// Xoá nhiều hình ảnh cùng lúc
// $('#del_img_list').on('click', function() {
//     $confirm = confirm('Bạn có chắc chắn muốn xoá các hình ảnh đã chọn không?');
//     if ($confirm == true)
//     {
//         $id_img = [];
//
//         $('#list_img input[type="checkbox"]:checkbox:checked').each(function(i) {
//             $id_img[i] = $(this).val();
//         });
//
//         if ($id_img.length === 0)
//         {
//             alert('Vui lòng chọn ít nhất một hình ảnh.');
//         }
//         else
//         {
//             $.ajax({
//                 url : $_DOMAIN + 'photos.php',
//                 type : 'POST',
//                 data : {
//                     idImg : $id_img,
//                     action : 'delete_img_list'
//                 },
//                 success : function(data) {
//                     location.reload();
//                 }, error : function() {
//                     alert('Đã có lỗi xảy ra, hãy thử lại.');
//                 }
//             });
//         }
//     }
//     else
//     {
//         return false;
//     }
// });
//
// // Xoá ảnh chỉ định
// $('.del-img').on('click', function() {
//     $confirm = confirm('Bạn có chắc chắn muốn xoá ảnh này không?');
//     if ($confirm == true)
//     {
//         $id_img = $(this).attr('data-id');
//
//         $.ajax({
//             url : $_DOMAIN + 'photos.php',
//             type : 'POST',
//             data : {
//                 idImg : $id_img,
//                 act : 'delete_img'
//             },
//             success : function() {
//                 location.reload();
//             }
//         });
//     }
//     else
//     {
//         return false;
//     }
// });
