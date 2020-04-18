import $ from 'jquery';

class Search {
  // 1. describe and create/initiate our object
  constructor() {
    this.addSearchHTML();
    this.openButton        = $('.js-search-trigger') ;
    this.closeButton       = $('.search-overlay__close');
    this.searchOverlay     = $('.search-overlay');
    this.searchOverlayOpen = false;
    this.searchField       = $('#search-term');
    this.typingTimer;
    this.searchFieldPreviousValue;
    this.spinnerVisible    = false;
    this.resultsArea       = $('#search-overlay__results');
    this.events();
  }

  // 2. events
  events() {
    this.openButton.on('click', this.openSearchOverlay.bind(this));
    this.closeButton.on('click', this.closeSearchOverlay.bind(this));
    $(document).on('keydown', this.keyDispatcher.bind(this));
    this.searchField.on('keyup', this.typingLogic.bind(this));
  }

  // 3. methods (functions, actions...)
  openSearchOverlay() {
    this.searchOverlay.addClass('search-overlay--active');
    this.searchOverlayOpen = true;
    setTimeout(() => this.searchField.focus(), 301);
    $('body').addClass('body-no-scroll');
    return false;
  }


  closeSearchOverlay() {
    this.searchOverlay.removeClass('search-overlay--active');
    this.searchOverlayOpen = false;
    this.clearSearchField();
    $('body').removeClass('body-no-scroll');
  }


  keyDispatcher(event) {
    // 's' key opens the search overlay
    if (event.keyCode === 83 && !this.searchOverlayOpen && !$('input, select, textarea').is(':focus')) {
      this.openSearchOverlay();
    }
    // 'esc' key closes the search overlay
    if (event.keyCode === 27 && this.searchOverlayOpen) {
      this.closeSearchOverlay();
    }
  }


  typingLogic() {
    if (this.searchField.val() !== this.searchFieldPreviousValue) {
      clearTimeout(this.typingTimer);

      if (this.searchField.val()) {
        if (!this.spinnerVisible) {
          this.resultsArea.html('<div class="spinner-loader"></div>');
          this.spinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.displayResults.bind(this), 750);
      }
      else {
        this.resultsArea.html('');
        this.spinnerVisible = false;
      }
    }
    this.searchFieldPreviousValue = this.searchField.val();
  }

  displayResults() {
    $.getJSON(universityData.siteUrl + '/wp-json/university/v1/search?term=' + this.searchField.val(), searchResults => {
      this.resultsArea.html(`
      <div class="row">
        <div class="one-third">
          <h2 class="search-overlay__section-title">General Information</h2>
          ${searchResults.general.length ? `
            <ul class="link-list min-list">${searchResults.general.map(item => `
              <li>
                <a href="${item.url}">${item.title}</a> ${item.post_type === 'post' ? `by ${item.author_name}` : ''}
              </li>`).join('')}
            </ul>` : `
            <p>No general information matches that search.</p>`}
        </div>

        <div class="one-third">
          <h2 class="search-overlay__section-title">Programs</h2>
          ${searchResults.programs.length ? `
            <ul class="link-list min-list">${searchResults.programs.map(item => `
              <li>
                <a href="${item.url}">${item.title}</a>
              </li>`).join('')}
            </ul>` : `
            <p>No programs match that search. <a href="${universityData.siteUrl}/programs">View all programs</a></p>`}
          <h2 class="search-overlay__section-title">Professors</h2>
          ${searchResults.professors.length ? `
            <ul class="professor-cards">${searchResults.professors.map(item => `
              <li class="professor-card__list-item">
                <a class="professor-card" href="${item.url}">
                  <img class="professor-card__image" src="${item.thumbnail}" alt="${item.thumbnail_caption}">
                  <span class="professor-card__name">${item.title}</span>
                </a>
              </li>`).join('')}
            </ul>` : `
            <p>No professors match that search.`}
        </div>

        <div class="one-third">
          <h2 class="search-overlay__section-title">Campuses</h2>
          ${searchResults.campuses.length ? `
            <ul class="link-list min-list">${searchResults.campuses.map(item => `
              <li>
                <a href="${item.url}">${item.title}</a>
              </li>`).join('')}
            </ul>` : `
            <p>No campuses match that search. <a href="${universityData.siteUrl}/campuses">View all campuses</a></p>`}
          <h2 class="search-overlay__section-title">Events</h2>
          ${searchResults.events.length ? `
            ${searchResults.events.map(item => `
              <div class="event-summary">
                <a class="event-summary__date t-center" href="${item.url}">
                  <span class="event-summary__month">${item.month}</span>
                  <span class="event-summary__day">${item.day}</span>
                </a>
                <div class="event-summary__content">
                  <h5 class="event-summary__title headline headline--tiny">
                    <a href="${item.url}">${item.title}</a>
                  </h5>
                  <p>
                    ${item.description} <a href="${item.url}" class="nu gray">Learn more</a>
                  </p>
                </div>
              </div>`).join('')}` : `
            <p>No events match that search. <a href="${universityData.siteUrl}/events">View all events</a></p>`}
        </div>
      </div>
      `);
      this.spinnerVisible = false;
    });
  }


  clearSearchField() {
    this.resultsArea.html('');
    this.searchField.val('');
    this.searchFieldPreviousValue = null;
    clearTimeout(this.typingTimer);
  }


  addSearchHTML() {
    $('body').append(`
      <div class="search-overlay">
        <div class="search-overlay__top">
          <div class="container">
            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
            <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
            <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
          </div>
        </div>
        <div class="container">
          <div id="search-overlay__results"></div>
        </div>
      </div>
    `);
  }

}

export default Search;
