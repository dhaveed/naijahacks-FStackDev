import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Routes, RouterModule } from '@angular/router';

import { IonicModule } from '@ionic/angular';

import { ViewFarmsPage } from './view-farms.page';
import { TabsComponent } from '../tabs/tabs.component';

const routes: Routes = [
  {
    path: '',
    component: ViewFarmsPage
  }
];

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    RouterModule.forChild(routes)
  ],
  declarations: [ViewFarmsPage, TabsComponent]
})
export class ViewFarmsPageModule {}
