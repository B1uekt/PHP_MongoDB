function UpdateGV(button){
    const ID = button.value;
    //console.log(ID);
    let requestGVInfo = new XMLHttpRequest();
    requestGVInfo.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        console.log(this.response);
    const GV = JSON.parse(this.response);  
    document.getElementById("name").value = GV["TENGV"];
    document.getElementById("email").value = GV["EMAIL"];
    document.getElementById("phone").value = GV["SDT"];
    document.getElementById("status").value = GV["TRANGTHAI"];
    document.getElementById("khoa").value = GV["MajorName"];
    }
}
requestGVInfo.open("POST", "i4GV.php?MaGV=" + ID);
requestGVInfo.send();
}
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