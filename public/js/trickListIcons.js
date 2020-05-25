$('#rowLoader').click(() => {
    const oldCounterValue = +$('#row-counter').val();

    $('#row-counter').val(oldCounterValue + 1);

    const newCounterValue = +$('#row-counter').val();

    $(`#rowOfTricks${newCounterValue}`).removeClass('d-none').addClass('d-flex flex-wrap flex-md-nowrap justify-content-md-around justify-content-center');

    if (newCounterValue === +$('#totalRow').val()) {
        $('#rowLoader').addClass('d-none');
        $('#arrowUp').removeClass('d-none').addClass('d-flex justify-content-center');
    }
})