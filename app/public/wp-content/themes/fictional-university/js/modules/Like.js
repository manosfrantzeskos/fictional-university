import $ from 'jquery';

class Like {
  constructor() {
    this.events();
  }

  events() {
    $('.like-box').on('click', this.clickDispatcher.bind(this));
  }

  clickDispatcher(event) {
    const likeBoxClicked = $(event.target).closest('.like-box');

    if (likeBoxClicked.closest('.like-box').attr('data-exists') === 'no') {
      this.createLike(likeBoxClicked);
    }
    else {
      this.deleteLike(likeBoxClicked);
    }
  }

  createLike(likeBoxClicked) {
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.siteUrl + '/wp-json/university/v1/like',
      type: 'POST',
      data: {
        professorID: likeBoxClicked.data('id'),
        professorTitle: likeBoxClicked.data('title')
      },
      success: response => {
        likeBoxClicked.attr('data-exists', 'yes');

        let orgNumOfLikes = likeBoxClicked.find('.like-count').html();
        let newNumOfLikes = parseInt(orgNumOfLikes, 10) + 1;

        likeBoxClicked.find('.like-count').html(newNumOfLikes);
        likeBoxClicked.attr('data-like', response);
      },
      error: response => {
        console.log(response);
      }
    });
  }

  deleteLike(likeBoxClicked) {
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.siteUrl + '/wp-json/university/v1/like',
      type: 'DELETE',
      data: {
        likeID: likeBoxClicked.attr('data-like')
      },
      success: response => {
        likeBoxClicked.attr('data-exists', 'no');

        let orgNumOfLikes = likeBoxClicked.find('.like-count').html();
        let newNumOfLikes = parseInt(orgNumOfLikes, 10) - 1;

        likeBoxClicked.find('.like-count').html(newNumOfLikes);
        likeBoxClicked.attr('data-like', '');
      },
      error: response => {
        console.log(response);
      }
    });

    console.log(likeBoxClicked.attr('data-like'));
  }
}

export default Like;
