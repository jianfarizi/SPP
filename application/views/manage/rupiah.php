<script type="text/javascript">
// Fungsi untuk menghapus spasi di awal dan akhir string
function rptrim(inputString) {
    var returnString = inputString + "";
    var removeChar = ' ';

    // Jika karakter yang akan dihapus ada
    if (removeChar.length) {
        // Hapus spasi di awal string
        while ('' + returnString.charAt(0) == removeChar) {
            returnString = returnString.substring(1, returnString.length);
        }
        // Hapus spasi di akhir string
        while ('' + returnString.charAt(returnString.length - 1) == removeChar) {
            returnString = returnString.substring(0, returnString.length - 1);
        }
    }

    return returnString;
}

// Fungsi untuk menghapus nol di depan angka
function removeLeadingZero(number) {
    if (number.length > 1) {
        // Hapus nol di depan string
        while ('' + number.charAt(0) == '0') {
            number = number.substring(1, number.length);
        }

        // Jika setelah penghapusan nol string menjadi kosong, set nilai menjadi "0"
        if (number.length == 0)
            number = "0";
    }
    return number;
}

// Fungsi untuk mengonversi angka menjadi format Rupiah
function numberToRupiah(number) {
    var original = number;
    number = rptrim(number);

    var positif = true;
    // Jika angka negatif, tandai dan hapus tanda minus
    if (number.charAt(0) == '-') {
        positif = false;
        number = number.substring(1, number.length);
        number = rptrim(number);
    }

    number = removeLeadingZero(number);

    // Jika bukan angka, kembalikan nilai asli
    if (!rpIsNumber(number))
        return original;

    var result = "";
    if (number.length < 4) {
        result = "" + number;
    } else {
        var count = 0;
        // Tambahkan titik sebagai pemisah ribuan
        for (i = number.length - 1; i >= 0; i--) {
            result = number.charAt(i) + result;
            count++;

            if ((count == 3) && (i > 0)) {
                result = '.' + result;
                count = 0;
            }
        }
        result = "" + result;
    }

    // Jika angka negatif, tambahkan tanda kurung
    if (!positif)
        result = "(" + result + ")";

    return result;
}

// Fungsi untuk mengonversi format Rupiah menjadi angka
function rupiahToNumber(rp) {
    var result = '';

    rp = rptrim(rp);
    var positif = true;
    var isvalid = true;
    if (rp.length > 0) {
        // Jika format negatif, tandai dan hapus tanda kurung
        if (rp.charAt(0) == "(") {
            positif = false;
            rp = rp.substring(1, rp.length);
            rp = rptrim(rp);
        }

        // Proses setiap karakter, hanya ambil angka dan karakter yang valid
        for (i = 0; isvalid && i < rp.length; i++) {
            var chr = rp.charAt(i);
            var asc = chr.charCodeAt(0);

            if (asc >= 48 && asc <= 57) {
                result = result + chr;
            } else {
                isvalid = (asc == 82 || asc == 114 || asc == 80 || asc == 112 || asc == 32 || asc == 46 || asc == 40 ||
                    asc == 41);
            }
        }
    }

    // Jika format valid, kembalikan angka dengan tanda negatif jika perlu
    if (isvalid) {
        if (positif)
            return result;
        else
            return "-" + result;
    } else {
        return rp;
    }
}

// Fungsi untuk memeriksa apakah string hanya berisi angka
function rpIsNumber(input) {
    var isnum = true;
    for (i = 0; isnum && i < input.length; i++) {
        var asc = input.charCodeAt(i);
        isnum = (asc >= 48 && asc <= 57);
    }

    return isnum;
}

// Fungsi untuk memformat input sebagai Rupiah
function formatRupiah(id) {
    var num = id.value;
    id.value = numberToRupiah(num);
}

// Fungsi untuk menghapus format Rupiah dari input
function unformatRupiah(id) {
    var num = id.value;
    id.value = rupiahToNumber(num);
}
</script>