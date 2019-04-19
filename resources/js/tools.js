window.urldomine = document.location.origin + '/';


export const options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-bottom-center",
    "preventDuplicates": false,
    "showDuration": "300",
    "hideDuration": "300",
    "timeOut": "2000",
    "extendedTimeOut": "500",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

export function rangoutil (totalpage, currentpage) {
    let star, end, total;
    total = (totalpage !== null) ? parseInt(totalpage) : 0;
    if (total <= 5) {
        star = 1;
        end = total + 1
    } else {
        if (currentpage <= 2) {
            star = 1;
            end = 6;
        } else if (currentpage + 2 >= total) {
            star = total - 5;
            end = total + 1
        } else {
            star = currentpage - 2;
            end = currentpage + 3
        }
    }
    let range = [];
    for (let i = star; i < end; i++) {
        range.push(i)
    }
    return range
}


function keyvalid (e) {

    let key = e.key;

    const permitidos = ['.', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'Backspace', 'ArrowLeft', 'ArrowLeft', 'Delete', 'Tab'];

    if (!permitidos.includes(key)) e.preventDefault()

}


function fixdate (dt) {

    dt = new Date(dt);

    let m =  dt.getMonth() < 9 ? '0' +  (dt.getMonth() + 1) : dt.getMonth() + 1;

    let d = dt.getDate() < 10 ? '0' +  dt.getDate() : dt.getDate();

    return  d + '/' + m + '/' + dt.getFullYear();
}

export function dateEs(dt) {
   return new Date(dt.replace(/-/g, '/')).toLocaleDateString()
}


function dec2hex (dec) {
    return ('0' + dec.toString(16)).substr(-2)
}

export function generateId (len) {
    var arr = new Uint8Array((len || 40) / 2);
    window.crypto.getRandomValues(arr);
    return Array.from(arr, dec2hex).join('')
}



Vue.directive('focus', {
    inserted: function (el) {
        el.focus()
    }
});

Vue.directive('numeric-only', {
    bind(el) {
        el.addEventListener('keydown', (e) => {
            if ([46, 8, 9, 27, 13, 110, 190].indexOf(e.keyCode) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode === 65 && e.ctrlKey === true) ||
                // Allow: Ctrl+C
                (e.keyCode === 67 && e.ctrlKey === true) ||
                // Allow: Ctrl+X
                (e.keyCode === 88 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault()
            }
        })
    }
});
