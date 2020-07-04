<template>
  <section class="pagebanner">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="content_404 text-center">
            <h1>{{title}}</h1>
            <h4>{{summary}}</h4>
            <p>{{ description }}</p>
            <a class="common_btn" href="/">Back to home</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
  export default {
    name: `ErrorPage`,
    props: ["status"],
    mounted() {
      $(".preloader")
        .delay(600)
        .fadeOut(300);

      let bodyElem = document.querySelector("body");
      bodyElem.classList.add("bg_right");
    },
    computed: {
      title() {
        return {
          503: "503",
          500: "500",
          404: "404",
          403: "403",
          429: "429"
        }[this.status];
      },
      summary() {
        return {
          503: "Service Unavailable",
          500: "Server Error",
          404: "Page Not Found",
          403: "Forbidden",
          429: "Too Many Requests"
        }[this.status];
      },
      description() {
        return {
          503: "Sorry, we are doing some maintenance. Please check back soon.",
          500: "Whoops, something went wrong on our servers.",
          404: "Sorry, the page you are looking for could not be found. You may have mis-typed a url. Go back home and try again",
          403: "Sorry, you are forbidden from accessing this page.",
          429: "You have tried to access this request too many times too quicky. Try again later."
        }[this.status];
      }
    }
  };
</script>
<style>
  /*! CSS Used from: /css/bootstrap.min.css */
  *,
  ::after,
  ::before {
    box-sizing: border-box;
  }
  section {
    display: block;
  }
  body {
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
      "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji",
      "Segoe UI Symbol";
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: left;
    background-color: #fff;
  }
  h1,
  h4 {
    margin-top: 0;
    margin-bottom: 0.5rem;
  }
  p {
    margin-top: 0;
    margin-bottom: 1rem;
  }
  a {
    color: #007bff;
    text-decoration: none;
    background-color: transparent;
    -webkit-text-decoration-skip: objects;
  }
  a:hover {
    color: #0056b3;
    text-decoration: underline;
  }
  h1,
  h4 {
    margin-bottom: 0.5rem;
    font-family: inherit;
    font-weight: 500;
    line-height: 1.2;
    color: inherit;
  }
  h1 {
    font-size: 2.5rem;
  }
  h4 {
    font-size: 1.5rem;
  }
  .container {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
  }
  @media (min-width: 576px) {
    .container {
      max-width: 540px;
    }
  }
  @media (min-width: 768px) {
    .container {
      max-width: 720px;
    }
  }
  @media (min-width: 992px) {
    .container {
      max-width: 960px;
    }
  }
  @media (min-width: 1200px) {
    .container {
      max-width: 1170px;
    }
  }
  .row {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
  }
  .col-lg-6 {
    position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
  }
  @media (min-width: 992px) {
    .col-lg-6 {
      -webkit-box-flex: 0;
      -ms-flex: 0 0 50%;
      flex: 0 0 50%;
      max-width: 50%;
    }
    .offset-lg-3 {
      margin-left: 25%;
    }
  }
  .text-right {
    text-align: right !important;
  }
  .text-center {
    text-align: center !important;
  }
  @media print {
    *,
    ::after,
    ::before {
      text-shadow: none !important;
      box-shadow: none !important;
    }
    a:not(.btn) {
      text-decoration: underline;
    }
    p {
      orphans: 3;
      widows: 3;
    }
    body {
      min-width: 992px !important;
    }
    .container {
      min-width: 992px !important;
    }
  }
  /*! CSS Used from: /css/payloan-icon.css */
  [class^="flaticon-"]:before,
  [class^="flaticon-"]:after {
    font-family: Flaticon;
    font-style: normal;
  }
  .flaticon-chevron:before {
    content: "\f107";
  }
  /*! CSS Used from: /css/preset.css */
  body {
    margin: 0;
    padding: 0;
  }
  body {
    line-height: 30px;
    color: #929292;
    letter-spacing: 0;
    font-size: 19px;
    font-weight: 400;
    overflow-x: hidden;
    transition: all ease 400ms;
    -webkit-transition: all ease 400ms;
    -moz-transition: all ease 400ms;
  }
  body.bg_right {
    background: url(/img/bg/1.png) no-repeat right top;
  }
  h1,
  h4 {
    color: #222222;
    font-weight: 300;
    margin: 0 0 15px;
  }
  a {
    color: #222222;
    text-decoration: none;
    transition: all ease 400ms;
    -webkit-transition: all ease 400ms;
    -moz-transition: all ease 400ms;
  }
  a:hover,
  a:focus {
    text-decoration: none;
    outline: 0;
  }
  a:focus {
    color: #fff;
  }
  .common_btn {
    border: none;
    font-size: 17px;
    font-weight: 700;
    background: #27b3ff;
    color: #fff;
    height: 55px;
    text-align: center;
    padding: 20px 46.1px;
    display: inline-block;
    line-height: 0.8;
    letter-spacing: 0;
    position: relative;
    border-radius: 3px;
    z-index: 1;
    cursor: pointer;
    outline: none;
    transition: all 0.4s ease-out;
    -moz-transition: all 0.4s ease-out;
    -webkit-transition: all 0.4s ease-out;
    -ms-transition: all 0.4s ease-out;
    -o-transition: all 0.4s ease-out;
  }
  .common_btn::after {
    background: #222222;
    border-radius: 3px;
    bottom: 0;
    content: "";
    height: 100%;
    left: 0;
    position: absolute;
    transform: scale(0);
    -moz-transform: scale(0);
    -webkit-transform: scale(0);
    -ms-transform: scale(0);
    -o-transform: scale(0);
    transition: all 0.2s linear 0s;
    -moz-transition: all 0.2s linear 0s;
    -webkit-transition: all 0.2s linear 0s;
    -ms-transition: all 0.2s linear 0s;
    -o-transition: all 0.2s linear 0s;
    width: 100%;
    z-index: -1;
  }
  .common_btn:hover::after {
    transform: scale(1);
    -moz-transform: scale(1);
    -webkit-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
  }
  .common_btn:hover {
    color: #fff;
  }
  /*! CSS Used from: /css/theme.css */
  .pagebanner {
    position: relative;
    padding: 151px 0 82px;
  }
  .copyright {
    position: relative;
    background: #fff;
    padding: 15px 0 7px;
  }
  .copyright p {
    font-size: 17px;
    line-height: 28px;
    color: #929292;
    margin: 0;
  }
  .copyright p a {
    display: inline-block;
    color: #27b3ff;
    font-weight: 700;
  }
  .copyright p a:hover {
    color: #929292;
  }
  #backTo {
    position: relative;
    height: 31px;
    width: 31px;
    background: #d6a8ec;
    border-radius: 50%;
    display: inline-block;
    color: #fff;
    text-align: center;
    font-size: 14px;
  }
  #backTo:hover {
    background: #27b3ff;
    color: #fff;
  }
  .content_404 {
    position: relative;
    padding: 0 25px;
  }
  .content_404 h1 {
    font-size: 250px;
    color: #27b3ff;
    font-weight: 900;
    line-height: 1;
    margin: 0 0 11px;
  }
  .content_404 h4 {
    font-size: 22px;
    line-height: 35px;
    color: #383c5e;
    font-weight: 900;
    margin: 0 0 20px;
  }
  .content_404 p {
    font-size: 19px;
    line-height: 35px;
    color: #606378;
    margin-bottom: 39px;
  }
  .content_404 a.common_btn {
    padding: 22px 50px;
    height: 58px;
    -webkit-box-shadow: 0px 0px 25px 0px rgba(46, 55, 136, 0.3);
    -moz-box-shadow: 0px 0px 25px 0px rgba(46, 55, 136, 0.3);
    box-shadow: 0px 0px 25px 0px rgba(46, 55, 136, 0.3);
  }
  /*! CSS Used from: /css/responsive.css */
  @media (min-width: 320px) and (max-width: 767px) {
    body.bg_right {
      background-size: 70%;
    }
    #backTo {
      top: -30px;
    }
    .content_404 {
      padding: 0;
    }
    .content_404 h1 {
      font-size: 120px;
    }
  }
  @media (min-width: 768px) and (max-width: 991px) {
    body.bg_right {
      background-size: 35%;
    }
  }
  @media (min-width: 992px) and (max-width: 1199px) {
    body.bg_right {
      background-size: 35%;
    }
    .content_404 {
      padding: 0;
    }
  }
  /*! CSS Used fontfaces */
  @font-face {
    font-family: "Flaticon";
    src: url("/fonts/Flaticon.eot");
    src: url("/fonts/Flaticond41d.eot#iefix") format("embedded-opentype"),
      url("/fonts/Flaticon.woff2") format("woff2"),
      url("/fonts/Flaticon.woff") format("woff"),
      url("/fonts/Flaticon.ttf") format("truetype"),
      url("/fonts/Flaticon.svg#Flaticon") format("svg");
    font-weight: normal;
    font-style: normal;
  }
  @font-face {
    font-family: "Flaticon";
    src: url("/fonts/Flaticon.svg#Flaticon") format("svg");
  }
</style>
