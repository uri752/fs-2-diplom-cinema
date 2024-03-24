# Описание таблиц база данных sqlite
## алы - halls
- name - наименование зала
- rows - количество рядов
- cols - количество мест в ряду
- price - цена за обычное место
- price_vip - цена за vip место
- is_open - зал открыт для продаж
## Фильмы - movies
- title - наименование фильма
- duration - продолжительность фильма
## Сеансы - sessions
- start - начало сеанса
- hall_id - id зала
- movie_id - id фильма
- selected_seats - занятые места зала в виде сериализованной json-строки
- seance-seats - все места зала для сеанса в виде сериализованной json-строки
## Места - seats
- hall_id - id зала
- type_seat - виде места (обычное st-standart, vip, отсутствует- disable)
