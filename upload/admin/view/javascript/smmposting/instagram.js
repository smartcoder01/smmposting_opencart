// remove social GET variable
history.replaceState && history.replaceState(
    null, '', location.pathname + location.search.replace(/[\?&]s=[^&]+/, '').replace(/^&/, '?')
);
history.replaceState && history.replaceState(
    null, '', location.pathname + location.search.replace(/[\?&]error=[^&]+/, '').replace(/^&/, '?')
);


const igStatuses = JSON.parse('["\u0421\u043e\u0435\u0434\u0438\u043d\u0435\u043d\u0438\u0435 \u0441 \u0441\u0435\u0440\u0432\u0435\u0440\u043e\u043c Instagram","\u041f\u0440\u043e\u0432\u0435\u0440\u043a\u0430 \u0432\u0432\u043e\u0434\u0438\u043c\u044b\u0445 \u0434\u0430\u043d\u043d\u044b\u0445","\u0410\u0432\u0442\u043e\u0440\u0438\u0437\u0430\u0446\u0438\u044f","\u0421\u043e\u0437\u0434\u0430\u043d\u0438\u0435 \u0430\u043a\u043a\u0430\u0443\u043d\u0442\u0430","\u0421\u043e\u0445\u0440\u0430\u043d\u0435\u043d\u0438\u0435 \u0430\u043a\u043a\u0430\u0443\u043d\u0442\u0430","\u0417\u0430\u0432\u0435\u0440\u0448\u0435\u043d\u0438\u0435 \u0440\u0430\u0431\u043e\u0442\u044b \u0441\u043a\u0440\u0438\u043f\u0442\u0430"]');

// get status
function getIGStatus () {
    let status = '';
    let index = 0;
    const intervalStatus = setInterval(() => {
        status = igStatuses[index];
        if (index < igStatuses.length - 1) {
            index++;
        } else {
            clearInterval(intervalStatus);
        }
        $('.status-description').html(`<small>${status}...</small>`);
    }, 5000);
}


// ig login
async function IGLogin() {
    const username = $('.instagram_login').val();
    const password = $('.instagram_password').val();

    // if empty username or password
    if (username === '' || password === '') {
        Swal.fire({
            title: "Внимание",
            text: "Введите логин и пароль для авторизации",
            type: "warning",
        });
        return;
    }

    let result = await  $.ajax({
        method: "GET",
        url: 'https://smm-posting.ru/api/v2/chat/ig/loginCheck',
        data: {username: username, password: password},
        beforeSend: function( xhr ) {
            getIGStatus();
            Swal.queue([{
                imageUrl: "https://smm-posting.ru/images/ajax/loading.gif",
                imageWidth: 151,
                imageHeight: 151,
                imageAlt: 'Custom image',
                html: `<p class = "font-weight-bold h3">Подождите, выполняется запрос...</p><p class = "status-description"></p>`,
                showConfirmButton: false,
            }]);
        }
    });

    if (result == '') {
        //console.log('empty, but here');
        $("#addInstagram").submit();
        setTimeout(() => {
            window.location.href = `https://smm-posting.ru/smm/accounts?iglogin=Y&instagram_login=${username}`;
        }, 15000);
    } else {
        let answer = JSON.parse(result);
        if (answer['result']['ERROR'] === 'Y') {
            switch (answer['result']['TYPE']) {
                case 'LOGIN_ERROR':
                    Swal.fire({
                        title: "Внимание",
                        text: answer['result']['MESSAGE'],
                        type: "warning",
                    });
                    return;
                case 'WITH_2FA_LOGIN_ERROR':
                    const { value: code } = await Swal.fire({
                        title: "Введите код",
                        input: 'text',
                        inputValue: '',
                        showCancelButton: false,
                        inputValidator: (value) => {
                            if (!value) {
                                return "Необходимо ввести код!";
                            }
                        }
                    });
                    if (code) {
                        let resultFA = await  $.ajax({
                            method: "GET",
                            url: 'https://smm-posting.ru/api/v2/chat/ig/login2FA',
                            data: {username: username, password: password, code: code , fa: 'Y'},
                            beforeSend: function( xhr ) {
                                Swal.queue([{
                                    imageUrl: "https://smm-posting.ru/images/ajax/loading.gif",
                                    imageWidth: 151,
                                    imageHeight: 151,
                                    imageAlt: 'Custom image',
                                    html: `<p class = "font-weight-bold h3">Подождите, выполняется запрос...</p>`,
                                    showConfirmButton: false,
                                }]);
                            }
                        });
                        console.log(resultFA);
                        let answerFA = JSON.parse(resultFA);
                        //console.log(answerFA);
                        if (answerFA['result']['ERROR'] === 'N') {
                            $("#addInstagram").submit();
                        }
                    }
                    return;
                case 'SELECT_VERIF':

                    const inputOptions = new Promise((resolve) => {
                        {
                            resolve({
                                'sms': 'sms',
                                'email': 'email'
                            })
                        }
                    });

                    const { value: type } = await Swal.fire({
                        title: "Подтверждение профиля",
                        input: 'radio',
                        inputOptions: inputOptions,
                        inputValidator: (value) => {
                            if (!value) {
                                return "Необходимо ввести код!";
                            }
                        }
                    });

                    if (type) {
                        let resultGet = await  $.ajax({
                            method: "GET",
                            url: 'https://smm-posting.ru/api/v2/chat/ig/loginGetCode',
                            data: {username: username, password: password, type: type},
                            beforeSend: function( xhr ) {
                                Swal.queue([{
                                    imageUrl: "https://smm-posting.ru/images/ajax/loading.gif",
                                    imageWidth: 151,
                                    imageHeight: 151,
                                    imageAlt: 'Custom image',
                                    html: `<p class = "font-weight-bold h3">Подождите, выполняется запрос...</p>`,
                                    showConfirmButton: false,
                                }]);
                            }
                        });
                        let answerGet = JSON.parse(resultGet);
                        if (answerGet['result']['ERROR'] === 'Y') {
                            if (answerGet['result']['TYPE'] === 'INPUT_CODE') {
                                const { value: code } = await Swal.fire({
                                    title: "Введите код",
                                    input: 'text',
                                    inputValue: '',
                                    showCancelButton: false,
                                    inputValidator: (value) => {
                                        if (!value) {
                                            return "Необходимо ввести код!";
                                        }
                                    }
                                })

                                if (code) {

                                    let resultCode = await  $.ajax({
                                        method: "GET",
                                        url: 'https://smm-posting.ru/api/v2/chat/ig/login',
                                        data: {username: username, password: password, code: code},
                                        beforeSend: function( xhr ) {
                                            Swal.queue([{
                                                imageUrl: "https://smm-posting.ru/images/ajax/loading.gif",
                                                imageWidth: 151,
                                                imageHeight: 151,
                                                imageAlt: 'Custom image',
                                                html: `<p class = "font-weight-bold h3">Подождите, выполняется запрос...</p>`,
                                                showConfirmButton: false,
                                            }]);
                                        }
                                    });
                                    let answerCode = JSON.parse(resultCode);
                                    //console.log(answerCode);
                                    if (answerCode['result']['ERROR'] === 'N') {
                                        $("#addInstagram").submit();
                                    }
                                }
                            }
                        }
                    }
                    return;
            }
        }
        if (answer['result']['ERROR'] === 'N') {
            $("#addInstagram").submit();
        }
    }
}