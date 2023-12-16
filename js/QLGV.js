function validateForm() {
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var phone = document.getElementById("phone").value;

    // Kiểm tra nếu các trường không được để trống
    if (name === "" || email === "" || phone === "") {
        alert("Vui lòng nhập đầy đủ thông tin.");
        return false; // Ngăn chặn gửi form
    }

    // Kiểm tra định dạng email
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("Email không hợp lệ.");
        return false; // Ngăn chặn gửi form
    }

    // Kiểm tra định dạng số điện thoại
    var phoneRegex = /^\d{10,}$/;
    if (!phoneRegex.test(phone)) {
        alert("Số điện thoại không hợp lệ.");
        return false; // Ngăn chặn gửi form
    }

    // Nếu tất cả thông tin hợp lệ, cho phép gửi form
    return true;
}

function UpdateGV(button){
    const ID = button.value;
    //console.log(ID);
    let requestGVInfo = new XMLHttpRequest();
    requestGVInfo.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        console.log(this.response);
    const GV = JSON.parse(this.response);  
    document.getElementById("magv").value = GV["MAGV"];
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
function calculateAge(birthdate) {
    var birthDate = new Date(birthdate);
    var currentDate = new Date();
    var birthYear = birthDate.getFullYear();
    var currentYear = currentDate.getFullYear();

    var age = currentYear - birthYear;
    if (currentDate < new Date(currentYear, birthDate.getMonth(), birthDate.getDate())) {
        age--;
    }

    return age;
}
function validateAddForm() {
    var name = document.getElementById("addname").value;
    var email = document.getElementById("addemail").value;
    var sdt = document.getElementById("sdt").value;
    var birthday = document.getElementById("birthday").value;
    if (name === "" || email === "" || sdt === "") {
        alert("Vui lòng nhập đầy đủ thông tin.");
        
        return false; 
    }
    var age = calculateAge(birthday);
    if(age < 23){
        alert("Tuổi không hợp lệ");
        return false; 
    }
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("Email không hợp lệ.");
        return false; 
    }

    var phoneRegex = /^\d{10,}$/;
    if (!phoneRegex.test(sdt)) {
        alert("Số điện thoại không hợp lệ.");
        return false;
    }

    return true;
}

function redirectToUpdatePage(magv) {
    window.location.href = 'detail_page.php?magv=' + magv;
}
function Reset(magv){
    var confirmed = confirm("Bạn có chắc chắn muốn reset mật khẩu không?");

    if (confirmed) {
        window.location.href = 'resetpwd.php?magv=' + magv;
    }
}
