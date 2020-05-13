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