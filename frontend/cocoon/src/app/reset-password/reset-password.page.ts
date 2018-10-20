import { Component, OnInit } from '@angular/core';
import { NavController, MenuController  } from '@ionic/angular';

@Component({
  selector: 'app-reset-password',
  templateUrl: './reset-password.page.html',
  styleUrls: ['./reset-password.page.scss'],
})
export class ResetPasswordPage implements OnInit {

  constructor(
    public menuCtrl: MenuController, 
    public navCtrl: NavController
    ){
      this.menuCtrl.enable(false, 'appSidebar');
    }

  ngOnInit() {
  }

}
