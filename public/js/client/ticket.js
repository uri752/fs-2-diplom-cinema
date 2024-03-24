const seanceTable = document.querySelector('.data-seance');
const seance = JSON.parse(seanceTable.value);

document.querySelector('.ticket__title').textContent = seance.movie.title;
document.querySelector('.ticket__chairs').textContent = seatsForTicket();
document.querySelector('.ticket__hall').textContent = `${seance.hall.name}`;
document.querySelector('.ticket__start').textContent =`${seance.start}`;

//console.log(seance);

function seatsForTicket() {
    let result = '';
    for (let seat of seance.selected_seats) {
        result += `Ряд ${seat.row} Место ${seat.seat}; `;
    }
    result = result.slice(0, -2);
    return result;
}