import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

const routes: Routes = [
  {
    path: '',
    redirectTo: 'explore',
    pathMatch: 'full'
  },
  {
    path: 'home',
    loadChildren: './home/home.module#HomePageModule'
  },
  {
    path: 'list',
    loadChildren: './list/list.module#ListPageModule'
  },
  { path: 'settings', loadChildren: './settings/settings.module#SettingsPageModule' },
  { path: 'splash', loadChildren: './splash/splash.module#SplashPageModule' },
  { path: 'login', loadChildren: './login/login.module#LoginPageModule' },
  { path: 'register', loadChildren: './register/register.module#RegisterPageModule' },
  { path: 'reset-password', loadChildren: './reset-password/reset-password.module#ResetPasswordPageModule' },
  { path: 'marketplace', loadChildren: './marketplace/marketplace.module#MarketplacePageModule' },
  { path: 'view-farms', loadChildren: './view-farms/view-farms.module#ViewFarmsPageModule' },
  { path: 'explore', loadChildren: './explore/explore.module#ExplorePageModule' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule {}
