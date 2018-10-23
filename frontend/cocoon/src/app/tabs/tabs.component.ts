import { Component, OnInit } from '@angular/core';
import { HomePageModule } from '../home/home.module';
import { MarketplacePageModule } from '../marketplace/marketplace.module';
import { SettingsPageModule } from '../settings/settings.module';

@Component({
  selector: 'app-tabs',
  templateUrl: './tabs.component.html',
  styleUrls: ['./tabs.component.scss']
})
export class TabsComponent implements OnInit {

  tab1Root: any = HomePageModule;
  tab2Root: any = MarketplacePageModule;
  tab3Root: any = SettingsPageModule;

  constructor() { }

  ngOnInit() {
  }

}
