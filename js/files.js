window.addEventListener('DOMContentLoaded', () => {
    const dropdown_menu = document.querySelector('.files__manager__navigation__file-type__menu__wrapper'),
        dropdown_btn = document.querySelector('.files__manager__navigation__file-type__menu__button'),
        menu = document.querySelector('.files__manager__navigation__file-type__menu'),
        menu_item = document.querySelectorAll('.files__manager__navigation__file-type__menu__item'),
        current_file_type = document.querySelector('.files__manager__navigation__file-type__type'),
        dropdown_btn_icon = document.querySelector('.current-file-type'),
        file_view = document.querySelector('.files__manager__layout'),
        file_view_btns = document.querySelectorAll('.files__manager__navigation__file-view__item'),
        fileInfoBlock = document.querySelector('.files__info');
        const chooseFileBtn = document.querySelector('.files__upload__choice__button');
        const fileInput = document.querySelector('.files__upload__input');
        const fileName = document.querySelector('.files__upload__name');
        const filesSearch = document.querySelector('.files__search__input');
        const filesSearchButton = document.querySelector('.files__search__button');
        const parent = document.querySelector('.files__manager__layout__wrapper');
        const reload = document.querySelector('.files__manager__navigation__reload');
        
        reload.addEventListener('click', ()=>{
            getFiles();
        });

        dropdown_btn.addEventListener('click', ()=> {
        menu.classList.toggle('menu_active');
        dropdown_menu.classList.toggle('dropdown');
        });
    
        
    // Тип показываемого файла
        menu_item.forEach((item)=>{
        item.addEventListener('click', (e)=>{
            // console.log(e.target.getAttribute("data-file-type"));
            if(e.target.getAttribute("data-file-type") == "all") {
                dropdown_btn_icon.className = 'fa-regular';
                dropdown_btn_icon.classList.add('fa-file');
                current_file_type.innerText = "Все файлы";
            } else if(e.target.getAttribute("data-file-type") == "video") {
                dropdown_btn_icon.className = 'fa-regular';
                dropdown_btn_icon.classList.add('fa-file-video');
                current_file_type.innerText = "Видео файлы";
            } else if(e.target.getAttribute("data-file-type") == "audio") {
                dropdown_btn_icon.className = 'fa-regular';
                dropdown_btn_icon.classList.add('fa-file-audio');
                current_file_type.innerText = "Аудио файлы";
            } else if(e.target.getAttribute("data-file-type") == "image") {
                dropdown_btn_icon.className = 'fa-regular';
                dropdown_btn_icon.classList.add('fa-file-image');
                current_file_type.innerText = "Файлы иозображения";
            }
        });
        });
    // Функция для получения всех файлов пользователя
        async function getFiles() {
            
            removeAllChildren(parent);
            const formData = new FormData();
            formData.append('login', Cookies.get('login'));
            formData.append('email', Cookies.get('email'));
            formData.append('username', Cookies.get('username'));
            const dataJson = JSON.stringify(Object.fromEntries(formData.entries()));
            await fetch('../api/get_dir_data.php', {
                method: "POST",
                headers: {
                    'Content-type': 'application/json'
                },
                body: dataJson
            })
            .then(data=> data.json())
            .then((file)=>{
                makeAndShowFiles(file);
            });
        }
        //Функция для создания и отображения файлов в верстке
            function makeAndShowFiles(file){
                file.forEach(obj => {
                    const item = document.createElement("div");
                    item.classList.add('files__manager__layout__item');
                    item.innerHTML = 
                    `
                        <i class="fa-solid fa-file-pen files__manager__layout__item__icon"></i>
                        <i class="fa-solid fa-ellipsis-vertical files__manager__layout__item__button"></i>
                        <div class="files__manager__layout__item__name">${obj.filename}</div>
                        <div class="files__manager__layout__item__menu">
                            <div class="files__manager__layout__item__menu__download" data-name="${obj.filename}">Скачать</div>
                            <div class="files__manager__layout__item__menu__delete">Удалить</div>
                            <div class="files__manager__layout__item__menu__info">Инфо</div>
                        </div>
                    `;
                    parent.insertAdjacentElement('beforeend', item);
                });
                files_menu();
                download();
                info();
                deleteFile();
            }
        //Функция для открытия меню файла 
            function files_menu() {
            const all = document.querySelectorAll('.files__manager__layout__item');
            const menu_all = document.querySelectorAll('.files__manager__layout__item__menu');
            all.forEach(item => {
                const menu = item.querySelector('.files__manager__layout__item__menu');
                const menu_btn = item.querySelector('.files__manager__layout__item__button');
                menu_btn.addEventListener('click', ()=>{
                    if(menu.classList.contains('active_file_mini_menu')){
                        menu.classList.remove('active_file_mini_menu');
                    } else {
                        menu_all.forEach(item => {
                            item.classList.remove('active_file_mini_menu');
                        });
                        menu.classList.add('active_file_mini_menu');
                    }
                });
            });
            }
            getFiles();

        // Закрывать dropdown меню при клике вне этого меню
            const body = document.querySelector('body');
            body.addEventListener('click', (e)=>{
            const all = document.querySelectorAll('.files__manager__layout__item__menu');
            if(!e.target.classList.contains('files__manager__layout__item__button') && !e.target.classList.contains('files__manager__layout__item__menu__download') && !e.target.classList.contains('files__manager__layout__item__menu__delete') && !e.target.classList.contains('files__manager__layout__item__menu__info') && !e.target.classList.contains('files__manager__layout__item__menu')){
                all.forEach(item => {
                    item.classList.remove('active_file_mini_menu');
                });
            }
            });
        
        // Функция для смены вида отображения файлов
        function files_view(){
            file_view_btns.forEach(item => {
                item.addEventListener('click', ()=> {
                    file_view_btns.forEach(btn => {
                        btn.classList.remove('current-files-view');
                    });
                    item.classList.add('current-files-view');
    
                    if(item.classList.contains('small-view')){
                        Cookies.set('file_view', 'small_files', { expires: 7 });
                        file_view.classList.remove('big_files');
                        file_view.classList.add('small_files');
                    } else {
                        Cookies.set('file_view', 'big_files', { expires: 7 });
                        file_view.classList.add('big_files');
                        file_view.classList.remove('small_files');
                    }
                });
            });
        }
        files_view();
        
        // Функция для сохранения выбранного вида отображения файлов в куки
        function file_view_cookies() {
            const small_view_btn = document.querySelector('.small-view');
            const big_view_btn = document.querySelector('.big-view');
            if(Cookies.get('file_view')){
                const cookie_file_view = Cookies.get('file_view');
                file_view.classList.add(cookie_file_view);
                if(cookie_file_view == 'big_files') {
                    big_view_btn.classList.add('current-files-view');
                } else {
                    small_view_btn.classList.add('current-files-view');
                }
            } else {
                small_view_btn.classList.add('current-files-view');
                file_view.classList.add('small_files');
                Cookies.set('file_view', 'small_files', { expires: 7 });
            }
        
        }
        file_view_cookies();
        
        chooseFileBtn.addEventListener('click', ()=>{
            fileInput.click();
        });
        fileInput.addEventListener('change', (e)=>{
            if(fileInput.files.length === 0){
                fileName.innerText = "Файл не выбран";
                return;
            }
            fileName.innerText = fileInput.files[0].name;
        });
        
        // Функция для загрузки файла на сервер 
        const fileUploadForm = document.querySelector('.files__upload');
        fileUploadForm.addEventListener('submit', async (e)=>{
            e.preventDefault();
            
            const fileField = document.querySelector('.files__upload__input').files[0];
            const formData = new FormData();
    
            formData.append('file', fileField);
            await fetch('../api/upload.php', {
                method: "POST",
                body: formData
            })
            .then(data => {
                fileUploadForm.reset();
                fileName.innerText = "Файл не выбран";
                getFiles();
            })
            .catch(()=>{
                showError();
            });
        });
        
        
        //Функция для очистки отображения всех файлов в DOM 
    
        function removeAllChildren(element) {
            while (element.firstChild) {
            element.removeChild(element.firstChild);
            }
        }
        
        // Скакчивание файлов
        function download(){
            const file2 = document.querySelectorAll('.files__manager__layout__item__menu__download');
            file2.forEach((item)=>{
                item.addEventListener('click', async (e)=>{
                    const data = e.target.getAttribute("data-name");
                    await fetch('../api/download.php',{
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/octet-stream'
                    },
                    body: data
                })
                .then(res => res.blob()).then(blob => handler(blob, data));
                });
            });
        }
        
        function handler(item, name){
            const url = URL.createObjectURL(item);
            const link = document.createElement('a');
            link.href = url;
            link.download = name;
            link.style = "display: none";
            link.click();
            link.remove();
            URL.revokeObjectURL(url);
        }
        
        //Инфо о файлах
        function info(){
            const allInfoBtns = document.querySelectorAll('.files__manager__layout__item__menu__info');
            allInfoBtns.forEach(btn=>{
                btn.addEventListener('click', async (e)=>{
                    const fileName = new FormData();
                    fileName.append('name', e.target.parentElement.parentElement.querySelector('.files__manager__layout__item__menu__download').getAttribute('data-name'));
                    const dataJson = JSON.stringify(Object.fromEntries(fileName.entries()));
                    await fetch("../api/get_file_info.php", {
                        method: "POST",
                        headers: {
                            'Content-type': 'application/json'
                        },
                        body: dataJson
                    })
                    .then(res => res.json())
                    .then((fileInfo) =>  {
                        fileInfo.forEach(obj=>{
                            fileInfoBlock.classList.remove('hidden');
                            fileInfoBlock.innerHTML = 
                            `
                            <div class="files__info__header">
                            Инофрмация о файле
                            </div>
                            <div class="files__info__name">Имя файла: ${obj.filename}</div>
                            <div class="files__info__size">Размер файла: ${obj.filesize} Кб</div>
                            <div class="files__info__date">Дата загрузки файла: ${obj.date_of_upload}</div>
                            <div class="files__info__type">Тип файла: ${obj.type}</div>
                            <button class="files__info__close">Скрыть информацию</button>
                            `
                            const hidden = document.querySelector('.files__info__close');
                            hidden.addEventListener('click', ()=>{
                                fileInfoBlock.classList.add('hidden');
                            })
                        })
                    })
                    .catch(()=>{

                    });
                });
            })
        }
        //Удаление файлов
        function deleteFile(){
            const allDeleteBtns = document.querySelectorAll('.files__manager__layout__item__menu__delete');
            allDeleteBtns.forEach(btn=>{
                btn.addEventListener('click', async (e)=>{
                    const fileName = new FormData();
                    const fileTarget = e.target.parentElement.parentElement;
                    fileName.append('name', e.target.parentElement.parentElement.querySelector('.files__manager__layout__item__menu__download').getAttribute('data-name'));
                    const dataJson = JSON.stringify(Object.fromEntries(fileName.entries()));
                    await fetch("../api/delete_file.php", {
                        method: "POST",
                        headers: {
                            'Content-type': 'application/json'
                        },
                        body: dataJson
                    }).then(res=>{
                        if(res.status == 230){
                            fileTarget.remove();
                        } else {
                            throw new Error();
                        }
                    }).catch(()=>{

                    });
                })
            })
        }
        //Поиск файлов
        // let timer;
        

        const event = function(){
            searchFiles();
        }
        filesSearchButton.addEventListener('click', event);
        async function searchFiles() {
            try{
                if(filesSearch.value == ''){
                    throw new Error();
                }
                const fileName = new FormData();
                fileName.append('filename', filesSearch.value);
                const fileNameJson = JSON.stringify(Object.fromEntries(fileName.entries()));
                const response = await fetch('', {
                    method: "POST",
                    headers: {
                        'Content-type': 'application/json'
                    },
                    body: fileNameJson
                });
                if(response.status == 230){
                    const json = response.json();
                    showFoundFiles(json);
                } else {
                    throw new Error();
                }
            }
            catch{
                removeAllChildren(parent);
                parent.innerHTML = "Что то пошло не так, попробуйте снова";
                filesSearchButton.removeEventListener('click', event);
                setTimeout(()=>{
                    getFiles();
                    filesSearchButton.addEventListener('click', event);
                }, 3000);
            }
            
        }
        function showFoundFiles(json) {
            removeAllChildren(parent);
            makeAndShowFiles(json);
        }
        
});

//

                    