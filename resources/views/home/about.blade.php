<section class="about" id="about">
   <div class="about-sticky">
      <div class="container">
         <div class="about-panels text-center">
            <div class="about-panel is-active" data-about-panel="about-story" id="about-panel-story">
               <h3>ABOUT</h3>
               <div class="line"></div>
               <p class="about-text">@include('home.includes.story')</p>
            </div>

            <div class="about-panel" data-about-panel="about-services" id="about-panel-services">
               <div class="row justify-content-center">
                  <div class="col-sm-4">
                     <div class="icon"><i class="fa-solid fa-palette fa-3x" aria-hidden="true"></i></div>
                     <h2>We Design</h2>
                     <p>Websites</p>
                     <p>Advertising</p>
                     <p>Identity</p>
                  </div>
                  <div class="col-sm-4">
                     <div class="icon"><i class="fa-solid fa-laptop-code fa-3x" aria-hidden="true"></i></div>
                     <h2>We Create</h2>
                     <p>Web Applications</p>
                     <p>Web Apps</p>
                     <p>Media Integrations</p>
                  </div>
                  <div class="col-sm-4">
                     <div class="icon"><i class="fa-solid fa-heart fa-3x" aria-hidden="true"></i></div>
                     <h2>We Love</h2>
                     <p>Good UI</p>
                     <p>Clean Design</p>
                     <p>Happy Clients</p>
                  </div>
               </div>
            </div>
         </div>

         <nav class="visually-hidden" aria-hidden="true">
            <ul id="aboutSpyNav">
               <li><a href="#about-story">About story</a></li>
               <li><a href="#about-services">About services</a></li>
            </ul>
         </nav>
      </div>
   </div>

   <div class="about-spy-track" aria-hidden="true">
      <div class="about-spy-target" id="about-story"></div>
      <div class="about-spy-target" id="about-services"></div>
   </div>
</section>
