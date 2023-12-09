function UpdateSV(button){
    const ID = button.value;
    console.log(ID);
    let requestSVInfo = new XMLHttpRequest();
    requestSVInfo.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        console.log(this.response);
    const SV = JSON.parse(this.response);  
    document.getElementById("name").value = SV["TENSV"];
    document.getElementById("class").value = SV["TENLOP"];
    document.getElementById("major").value = SV["TENNGANH"];
    document.getElementById("status").value = SV["TRANGTHAI"];
    document.getElementById("birthday").value = SV["NGAYSINH"];
    document.getElementById("address").value = SV["DIACHI"];
    document.getElementById("gender").value = SV["GIOITINH"];
    }
}
requestSVInfo.open("POST", "i4SV.php?MaSV=" + ID);
requestSVInfo.send();
}
function redirectToUpdatePage(masv) {
    // Chuyển đến trang cần thiết với thông tin cần thiết
    window.location.href = 'detail_page.php?masv=' + masv;
}
function Reset(magv) {
    var confirmed = confirm("Bạn có chắc chắn muốn reset mật khẩu không?");

    if (confirmed) {
        window.location.href = 'resetpwd.php?magv=' + magv;
    }
}
