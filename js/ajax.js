
function insertData(idform, pagesever) {
    var formData = new FormData(document.getElementById('formHocphan'));
    var request = new XMLHttpRequest();
    console.log(formData);
    request.onreadystatechange = function() {
        if (request.readyState == XMLHttpRequest.DONE) {
            if (request.status == 200) {
                console.log("Successfully inserted data");
                window.location.reload(true);
            } else {
                console.error('Failed to insert data');
                // Xử lý lỗi nếu có
            }
        }
    };

    request.open("POST", "themhocphan.php", true);
    request.send(formData);


    var modal = document.getElementById('addinfor');
    modal.style.display = 'none'; 
}