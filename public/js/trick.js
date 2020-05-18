$('#add-media').click(() => {
    const index = +$('#widgets-counter').val();
    const template = $('#trick_medias').data('prototype').replace(/__name__/g, index);

    $('#trick_medias').append(template);

    $('#widgets-counter').val(index + 1);

    handleDeleteButtons();
});

function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function() {
        const target = this.dataset.target;

        $(target).remove();
    });
}

function updateCounter() {
    const count = +$('#trick_medias div.form-group').length;

    $('#widgets-counter').val(count);
}

updateCounter();

handleDeleteButtons();

$('#add-image').click(() => {
    const index = +$('#widgets-counter2').val();
    const template = $('#trick_images').data('prototype').replace(/__name__/g, index);

    $('#trick_images').append(template);

    $('#widgets-counter2').val(index + 1);

    handleDeleteButtons();
});

function handleDeleteButtons2() {
    $('button[data-action="delete"]').click(function() {
        const target = this.dataset.target;

        $(target).remove();
    });
}

function updateCounter2() {
    const count = +$('#trick_images div.form-group').length;

    $('#widgets-counter2').val(count);
}

updateCounter2();

handleDeleteButtons2();