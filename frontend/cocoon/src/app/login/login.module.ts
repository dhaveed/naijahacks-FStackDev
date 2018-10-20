import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Routes, RouterModule } from '@angular/router';

import { IonicModule, NavController } from '@ionic/angular';

import { LoginPage } from './login.page';
import { MenuController } from '@ionic/angular';

const routes: Routes = [
  {
    path: '',
    component: LoginPage
  }
];

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    RouterModule.forChild(routes)
  ],
  declarations: [LoginPage]
})
export class LoginPageModule {
  constructor(
    public menuCtrl: MenuController, 
    public navCtrl: NavController
    ){
      this.menuCtrl.enable(false, 'appSidebar');
    }
}
