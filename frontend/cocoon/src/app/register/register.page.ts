import { Component, OnInit } from '@angular/core';
import { NavController, MenuController  } from '@ionic/angular';

@Component({
  selector: 'app-register',
  templateUrl: './register.page.html',
  styleUrls: ['./register.page.scss'],
})
export class RegisterPage implements OnInit {

  constructor(
    public menuCtrl: MenuController, 
    public navCtrl: NavController
    ){
      this.menuCtrl.enable(false, 'appSidebar');
    }

  ngOnInit() {
  }

}
