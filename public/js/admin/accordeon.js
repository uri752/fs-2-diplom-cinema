import resizeHall from "./resizeHall.js";
import hallConfigurate from "./hallConfigurate.js";
import addSeance from "./addSeance.js";
import delSeance from "./delSeance.js";
import viewSeances from "./viewSeances.js";
import inputError from "./inputError.js";

//--- Сворачивание разделов
const headers = Array.from(document.querySelectorAll('.conf-step__header'));
headers.forEach(header => header.addEventListener('click', () => {
  header.classList.toggle('conf-step__header_closed');
  header.classList.toggle('conf-step__header_opened');
}));

const hallsTable = document.querySelector('.data-halls');
const hallsData = JSON.parse(hallsTable.value);

hallsData.map(hall => {
    const arr = [];
    for (let i = 0; i < hall.seat.length; i++) {
        arr.push(hall.seat[i].type_seat);
    }
    hall.seat = arr;
})

//--- Установление выбранного зала для отображения
let choosenHall = hallsData.length - 1;
if (hallsData.length > 0) hallConfigurate(hallsData, choosenHall);

const seatTable = document.querySelector('.data-seats');
const seatData = JSON.parse(seatTable.value);

const moviesTable = document.querySelector('.data-movies');
const moviesData = JSON.parse(moviesTable.value).data;

const seancesTable = document.querySelector('.data-seances');
const seancesData = JSON.parse(seancesTable.value);

//--- Кнопка открытия-закрытия продаж
const openSales = document.querySelector('#open_sales');

openSales.onclick = () => {
    if (!hallsData[choosenHall].is_open) {
        openSales.textContent = 'Приостановить продажу билетов';
        hallsData[choosenHall].is_open = true;
        saveHall();
    } else {
        openSales.textContent = 'Открыть продажу билетов';
        hallsData[choosenHall].is_open = false;
        saveHall();
    }
}

function saveHall() {
    const token = document.querySelector('meta[name="csrf-token"]').content; 
    const options = {
        method: 'POST',
        body: JSON.stringify(hallsData[choosenHall]),
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': `${token}`}
    }
    
    fetch(`/admin/halls/${hallsData[choosenHall].id}`, options)
        .then(res=> {
            res.json();
            if (res.ok) {
                //alert('save');
            } else {
                throw new Error(res.status);
            }
        })    
}

//--- Проверка правильности ввода данных
inputError(moviesData, hallsData);

const abort = [...document.querySelectorAll('.abort')];
const dismiss = [...document.querySelectorAll('.popup__dismiss')];
const alert = [...document.querySelectorAll('.alert')];

for (let i = 0; i < abort.length; i++) {
    abort[i].addEventListener('click', close);
}

for (let i = 0; i < dismiss.length; i++) {
    dismiss[i].addEventListener('click', close);
}

function close(e) {
    e.preventDefault();
    const popup = [...document.querySelectorAll('.popup')];
    for (let i = 0; i < alert.length; i++) {
        alert[i].textContent = null;
    }
    for (let i = 0; i < popup.length; i++) {
        if (popup[i].classList.contains('active')) {
            popup[i].classList.remove('active');
        }
    }
}

//--- Выбор зала
const hallsList = [...document.getElementsByName('chairs-hall')];
const hallsList1 = [...document.getElementsByName('chairs-hall1')];

for (let i = 0; i < hallsList.length; i++) {
    hallsList1[i].addEventListener('input', function() {
        choosenHall = i;
        hallsList[i].checked = true;
        hallConfigurate(hallsData, choosenHall);
    })

    hallsList[i].addEventListener('input', function() {
        choosenHall = i;
        hallsList1[i].checked = true;
        hallConfigurate(hallsData, choosenHall);
    })
}

//--- Количество рядов и мест
document.querySelector('.rows').onchange = (e) => {
    resizeHall(hallsData, choosenHall,'rows', parseInt(e.target.value));
}

document.querySelector('.cols').onchange = (e) => {
    resizeHall(hallsData, choosenHall,'cols', parseInt(e.target.value));
}

//--- Установка цен
document.querySelector('.price').onchange = (e) => {
    const value = parseInt(e.target.value);
    if (!Number.isInteger(value) || value <= 0) {
        document.querySelector('.price').value = hallsData[choosenHall].price;
        return null;
    }
    hallsData[choosenHall].price = e.target.value;
}

document.querySelector('.vip_price').onchange = (e) => {
    const value = parseInt(e.target.value);
    if (!Number.isInteger(value) || value <= 0) {
        document.querySelector('.vip_price').value = hallsData[choosenHall].price_vip;
        return null
    }
    hallsData[choosenHall].price_vip = e.target.value;
}

//--- Сохранение hall_update
const formUpdate = document.getElementById('hall_update');
formUpdate.onsubmit = function(e) {
    e.preventDefault();

    const seatsArr1 = [];
    for (let i = 0; i < hallsData[choosenHall].seat.length; i++) {
        const type =  hallsData[choosenHall].seat[i];
        seatsArr1.push({hall_id: hallsData[choosenHall].id, type_seat: type});
    }
    delete hallsData[choosenHall].seat;
    document.querySelector('.data-tables').value = hallsData[choosenHall];
    
    const token = document.querySelector('meta[name="csrf-token"]').content;         
    const optionsHalls = {
        method: 'POST',
        body: JSON.stringify(hallsData[choosenHall]),
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': `${token}`}
    }
        
    fetch(`/admin/halls/${hallsData[choosenHall].id}`, optionsHalls)
        .then(res=> {
            res.json();
            if (res.ok) {
                //alert('save');
            } else {
                throw new Error(res.status);
            }
        })

        const optionsSeats = {
            method: 'POST',
            body: JSON.stringify(seatsArr1),
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': `${token}`}
        }
                
        fetch(`/admin/seats/${hallsData[choosenHall].id}`, optionsSeats)
        .then(res=> {
            res.json()
            if (res.ok) {
                //alert('save')
            } else {
                throw new Error(res.status)
            }
        })
        
}

//--- Отмена сохранения 
const cancel = [...document.querySelectorAll('.cancel')];
cancel.forEach(item => {
    item.onclick = (e) => {
        e.preventDefault();
        location.reload();
    }
})


//--- Добавление фильма
const wrapperMovies = document.querySelector(".conf-step__movies");
let addMovie = "";

for (let i = 0; i < moviesData.length; i++) {
    addMovie += `
        <div class="conf-step__movie">
            <img class="conf-step__movie-poster" alt="poster" src="/i/poster.png">
            <h3 class="conf-step__movie-title">${moviesData[i].title}</h3>
            <p class="conf-step__movie-duration">${moviesData[i].duration} минут</p>
            <input class="movie_id" type="hidden" value=${moviesData[i].id} />
            <button class="conf-step__button conf-step__button-trash trash_movie" onclick="deleteMovie(event)""></button>
        </div>
        
    `;
}

wrapperMovies.innerHTML = addMovie;

//--- Добавление и удаление сеанса
addSeance(hallsData, moviesData, seancesData);
delSeance(hallsData, moviesData, seancesData);


//--- Отображение сеанса
viewSeances(hallsData, moviesData, seancesData);

//--- Сохранение сеансов
const formSeance = document.getElementById('seance_update');
formSeance.onsubmit = function(e) {
    e.preventDefault();
        
    seancesData.forEach(seance => {
        delete seance.movie;
    });
            
    const token = document.querySelector('meta[name="csrf-token"]').content;         
    const options = {
        method: 'POST',
        body: JSON.stringify(seancesData),
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': `${token}` }        
    }
       
    fetch(`/admin/seances`, options)    
        .then(res=> {
            res.json();
            if (res.ok) {
                //alert('save');
            } else {
                throw new Error(res.status);
            }
        })
}