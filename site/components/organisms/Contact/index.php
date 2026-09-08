<section class="contact-section">
  <div class="contact-grid">
    <div class="contact-info">
      <?php snippet('atoms/Heading', ['level' => 'h2', 'text' => 'NapiĹˇte nĂˇm']) ?>
      <p>MĂˇte dotaz nebo zĂˇjem o spoluprĂˇci? NevĂˇhejte nĂˇs kontaktovat.</p>
    </div>
    <form class="contact-form" method="POST" action="">
      <?php snippet('atoms/Input', ['name' => 'name', 'label' => 'JmĂ©no a pĹ™Ă­jmenĂ­', 'required' => true]) ?>
      <?php snippet('atoms/Input', ['name' => 'email', 'type' => 'email', 'label' => 'VĂˇĹˇ e-mail', 'required' => true]) ?>
      <?php snippet('atoms/Input', ['name' => 'message', 'type' => 'textarea', 'label' => 'ZprĂˇva', 'required' => true]) ?>
      <?php snippet('atoms/Button', ['label' => 'Odeslat zprĂˇvu', 'type' => 'submit', 'style' => 'primary']) ?>
    </form>
  </div>
</section>
