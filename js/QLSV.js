function UpdateSV(button){
    const ID = button.value;
    let requestSVInfo = new XMLHttpRequest();
    requestSVInfo.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
    const SV = JSON.parse(this.response);  
    document.getElementById("masv").value = SV["MASV"];
    console.log(document.getElementById("masv").value);
    document.getElementById("name").value = SV["TENSV"];
    document.getElementById("class").value = SV["TENLOP"];
    document.getElementById("branch").value = SV["TENNGANH"];
    document.getElementById("major").value = SV["TENKHOA"];
    document.getElementById("status").value = SV["TRANGTHAI"];
    document.getElementById("birthday").value = SV["NGAYSINH"];
    document.getElementById("address").value = SV["DIACHI"];
    document.getElementById("gender").value = SV["GIOITINH"];
    }
}
requestSVInfo.open("POST", "i4SV.php?MaSV=" + ID);
requestSVInfo.send();
}
function updateMajorandBranch() {
    var selectedClass = document.getElementById("class").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "getMajorandBranch.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.response); 
            document.getElementById("major").value = response["TENKHOA"];
            document.getElementById("branch").value = response["TENNGANH"];
            console.log(selectedClass);
        }
    };
    xhr.send("selectedClass=" + selectedClass);
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
