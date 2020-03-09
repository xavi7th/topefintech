<template>
  <div class="rui-popup rui-popup-messenger" id="messenger">
    <form class="rui-messenger rui-messenger-mini">
      <div class="rui-messenger-head">
        <div class="input-group rui-messenger-search">
          <button
            type="button"
            class="btn btn-clean btn-uniform btn-grey-5"
            data-toggle="button"
            aria-pressed="false"
          >
            <span data-feather="search" class="rui-icon rui-icon-stroke-1_5"></span>
          </button>
          <input
            type="search"
            class="form-control form-control-clean"
            placeholder="Type to search..."
            data-toggle="input"
            autocomplete="off"
          />
        </div>
        <h4 class="mnb-2">Messenger</h4>
      </div>
      <div class="rui-messenger-list rui-scrollbar">
        <a
          class="btn rui-messenger-collapse-btn"
          data-toggle="collapse"
          href="#collapseOnline"
          role="button"
          aria-expanded="false"
          aria-controls="collapseOnline"
        >
          Online
          <span data-feather="chevron-right" class="rui-icon rui-icon-stroke-1_5"></span>
        </a>
        <div class="collapse show" id="collapseOnline">
          <div class="rui-messenger-collapse">
            <div class="media media-success media-filled">
              <a href="#" class="media-link rui-messenger-item">
                <span class="media-img">
                  <img src="/img/avatar-5.png" alt />
                </span>
                <span class="media-body">
                  <span class="media-title">Amber Smith</span>
                  <small class="media-subtitle">Bring abundantly creature great behold...</small>
                </span>
              </a>
              <a href="#" class="media-icon">
                <span data-feather="x" class="rui-icon rui-icon-stroke-1_5"></span>
              </a>
            </div>
            <div class="media media-success media-filled">
              <a href="#" class="media-link rui-messenger-item">
                <span class="media-img">F</span>
                <span class="media-body">
                  <span class="media-title">Frank Eaton</span>
                  <small class="media-subtitle">Porttitor facilisis quisque ultrices...</small>
                </span>
              </a>
              <a href="#" class="media-icon">
                <span data-feather="x" class="rui-icon rui-icon-stroke-1_5"></span>
              </a>
            </div>
          </div>
        </div>
        <a
          class="btn rui-messenger-collapse-btn collapsed"
          data-toggle="collapse"
          href="#collapseOffline"
          role="button"
          aria-expanded="false"
          aria-controls="collapseOffline"
        >
          Offline
          <span data-feather="chevron-right" class="rui-icon rui-icon-stroke-1_5"></span>
        </a>
        <div class="collapse" id="collapseOffline">
          <div class="rui-messenger-collapse">
            <div class="media media-warning media-filled">
              <a href="#" class="media-link rui-messenger-item">
                <span class="media-img">
                  <img src="/img/avatar-2.png" alt />
                </span>
                <span class="media-body">
                  <span class="media-title">Helen Holt</span>
                  <small class="media-subtitle">Upon us after sixth, under is appear...</small>
                </span>
              </a>
              <a href="#" class="media-icon">
                <span data-feather="x" class="rui-icon rui-icon-stroke-1_5"></span>
              </a>
            </div>
            <div class="media media-warning media-filled">
              <a href="#" class="media-link rui-messenger-item">
                <span class="media-img">S</span>
                <span class="media-body">
                  <span class="media-title">Steven Cross</span>
                  <small class="media-subtitle">Us earth our sixth cattle great without...</small>
                </span>
              </a>
              <a href="#" class="media-icon">
                <span data-feather="x" class="rui-icon rui-icon-stroke-1_5"></span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="rui-messenger-footer">
        <button type="button" class="btn btn-custom-round">
          <span data-feather="more-vertical" class="rui-icon rui-icon-stroke-1_5"></span>
        </button>
        <button type="button" class="btn btn-brand btn-uniform btn-round btn-sm">
          <span data-feather="plus" class="rui-icon rui-icon-stroke-1_5"></span>
        </button>
      </div>
      <div class="rui-messenger-chat">
        <div class="rui-messenger-head">
          <a href="#" class="btn btn-clean btn-uniform btn-grey-5 rui-messenger-back">
            <span data-feather="chevron-left" class="rui-icon rui-icon-stroke-1_5"></span>
          </a>
          <h4 class="mnb-4">Amber Smith</h4>
          <div class="rui-messenger-head-empty"></div>
        </div>
        <div class="rui-messenger-body rui-scrollbar">
          <div>
            <div class="rui-messenger-message rui-messenger-message-structure">
              <ul>
                <li></li>
              </ul>
              <div class="rui-messenger-message-edit">
                <a href="#" class="btn">
                  <span data-feather="edit-2" class="rui-icon rui-icon-stroke-1_5"></span>
                </a>
                <a href="#" class="btn">
                  <span data-feather="trash" class="rui-icon rui-icon-stroke-1_5"></span>
                </a>
              </div>
              <small class="rui-messenger-message-time"></small>
            </div>
            <small class="rui-messenger-message-datetime">2 days ago</small>
            <div class="rui-messenger-message rui-messenger-message-incoming">
              <ul>
                <li>The last album.</li>
                <li>I can’t open the last album!</li>
              </ul>
              <small class="rui-messenger-message-time">10:19</small>
            </div>
            <div class="rui-messenger-message rui-messenger-message-incoming">
              <ul>
                <li>Gues, I can’t open the last album...</li>
              </ul>
              <small class="rui-messenger-message-time">10:20</small>
            </div>
            <small class="rui-messenger-message-datetime">Today</small>
            <div class="rui-messenger-message">
              <ul>
                <li>123</li>
              </ul>
              <small class="rui-messenger-message-time">10:29</small>
              <div class="rui-messenger-message-edit">
                <a href="#" class="btn">
                  <span data-feather="edit-2" class="rui-icon rui-icon-stroke-1_5"></span>
                </a>
                <a href="#" class="btn">
                  <span data-feather="trash" class="rui-icon rui-icon-stroke-1_5"></span>
                </a>
              </div>
            </div>
            <div class="rui-messenger-message">
              <ul>
                <li>Haha Amber! You are so nice! :smile:</li>
              </ul>
              <small class="rui-messenger-message-time">10:30</small>
              <div class="rui-messenger-message-edit">
                <a href="#" class="btn">
                  <span data-feather="edit-2" class="rui-icon rui-icon-stroke-1_5"></span>
                </a>
                <a href="#" class="btn">
                  <span data-feather="trash" class="rui-icon rui-icon-stroke-1_5"></span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="rui-messenger-footer">
          <div class="input-group mnt-10 mnb-10">
            <div class="input-group-prepend mnl-2">
              <input type="file" class="rui-messenger-custom-file" id="customFileLang" lang="es" />
              <label class="btn btn-clean btn-uniform btn-grey-5 mb-0" for="customFileLang">
                <span data-feather="paperclip" class="rui-icon rui-icon-stroke-1_5"></span>
              </label>
            </div>
            <textarea
              class="form-control form-control-clean rui-messenger-textarea"
              placeholder="Write a message..."
            ></textarea>
            <div class="input-group-append ml-2">
              <a href="#" class="btn btn-clean btn-uniform btn-grey-5 rui-messenger-send">
                <span data-feather="send" class="rui-icon rui-icon-stroke-1_5"></span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
