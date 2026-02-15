function getDokumenSisa() {
    return JSON.parse(localStorage.getItem("dokumen"));
}

function forgetDokumenSisa() {
    localStorage.clear();
}

function saveDokumenSisa(namaFile) {
    var dokSisaLama = getDokumenSisa();
    if (dokSisaLama != null) {
        dokSisaLama.push(namaFile);
        localStorage.setItem("dokumen", JSON.stringify(dokSisaLama));
    } else {
        dokSisaBaru = [namaFile];
        localStorage.setItem("dokumen", JSON.stringify(dokSisaBaru));
    }
}

function deleteDokumenSisa(namaFile) {
    var dokumenSisa = getDokumenSisa();
    if (dokumenSisa != null) {
        var posisi = dokumenSisa.indexOf(namaFile);
        if (posisi > -1) {
            // only splice array when item is found
            dokumenSisa.splice(posisi, 1); // 2nd parameter means remove one item only
            localStorage.setItem("dokumen", JSON.stringify(dokumenSisa));
        }
    }
}

function activeAdd(name) {
    var listItems = $("#list-sidebar li");
    listItems.each(function (i, li) {
        var a = $(li).find("a");
        var listItem = $(li).find("p");
        var html = $(listItem).html().toLowerCase();
        if (html.includes(name)) {
            $(a).addClass("active");
        }
    });
}

function activeRemove(name) {
    var listItems = $("#list-sidebar li");
    listItems.each(function (i, li) {
        var a = $(li).find("a");
        var listItem = $(li).find("p");
        var html = $(listItem).html().toLowerCase();
        if (html.includes(name)) {
            $(a).removeClass("active");
        }
    });
}

function menuOpen(name) {
    var listItems = $("#list-sidebar li");
    listItems.each(function (i, li) {
        var listItem = $(li).find("p");
        var html = $(listItem).html().toLowerCase();
        if (html.includes(name)) {
            $(li).addClass("menu-open");
        }
    });
}

function swalDelete(id, name, e) {
    swal({
        title: "Apa kamu yakin?",
        text: "Akan menghapus data dengan " + name + " and id " + id,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            e.submit();
        }
    });
}

function swalHapus(e) {
    swal({
        title: "Apa kamu yakin?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            e.submit();
        }
    });
}

function logout(event) {
    event.preventDefault();
    if (confirm("Apa kamu yakin ? ")) {
        document.getElementById("logout-form").submit();
    }
}

function customFileLabel(e) {
    var fileName = e.files[0].name;
    $(e).next(".custom-file-label").text(fileName);
}

function scrollToPosition(position) {
    $("html, body").animate(
        {
            scrollTop: position,
        },
        500
    ); // 1000 milliseconds (1 second) for the animation
}

function saveStateTab(idElementTab) {
    localStorage.setItem("lastTab", idElementTab);
    let scrollPosition = $(window).scrollTop();
    localStorage.setItem("scrollPosition", scrollPosition);
}

function formatRupiah(angka, elementHelp = null) {
    var number_string = angka.toString().replace(/[^,\d]/g, "");
    var split = number_string.split(",");
    var sisa = split[0].length % 3;
    var rupiah = split[0].substr(0, sisa);
    var ribuan = split[0].substr(sisa).match(/\d{3}/g);

    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
    rupiah = "Rp " + rupiah;
    if (elementHelp != null) {
        $(elementHelp).html(rupiah);
        return;
    }
    return rupiah;
}

function showHidePassword(event, elementId) {
    let i = event.currentTarget.querySelector("i");
    let passwordType = $(elementId).attr("type");
    if (passwordType == "text") {
        $(elementId).attr("type", "password");
        $(i).removeClass("fa fa-eye");
        $(i).addClass("fa fa-eye-slash");
    } else {
        $(elementId).attr("type", "text");
        $(i).removeClass("fa fa-eye-slash");
        $(i).addClass("fa fa-eye");
    }
}

//https://summernote.org/deep-dive/#basic-api
function toolbarSummerNote() {
    return [
        ["style", ["style"]],
        [
            "font",
            [
                "bold",
                "italic",
                "underline",
                "strikethrough",
                "superscript",
                "subscript",
                "clear",
            ],
        ],
        ["fontname", ["fontname"]],
        ["fontsize", ["fontsize"]],
        ["color", ["color"]],
        ["para", ["ol", "ul", "paragraph", "height"]],
        ["table", ["table"]],
        ["insert", ["link"]],
        ["view", ["undo", "redo", "fullscreen", "codeview", "help"]],
    ];
}

function runAjaxRefreshCard(formId, url, formButtonId, cardRefreshId) {
    $("#" + formId).submit(function (e) {
        e.preventDefault();
        let fd = new FormData(this);
        $.ajax({
            type: "POST",
            url: url,
            data: fd,
            contentType: false,
            processData: false,
            beforeSend: function () {
                let html = `<div class="spinner-border spinner-border-sm ml-auto" role="status" aria-hidden="true"></div>`;
                $("#" + formButtonId).html(html);
            },
            success: function (response) {
                document.getElementById(cardRefreshId).click();
                swalToast(response.message, response.data);
            },
        });
    });
}

function copy(link) {
    try {
        navigator.clipboard.writeText(link);
        swalToast(
            200,
            "Berhasil menyalin url file, siap dibagikan dengan mempastekannya"
        );
    } catch (error) {
        swalToast(500, "Gagal menyalin file, error " + error);
    }
}

function convertToPlain(html) {
    var tempDivElement = document.createElement("div");
    tempDivElement.innerHTML = html;
    return tempDivElement.textContent || tempDivElement.innerText || "";
}
