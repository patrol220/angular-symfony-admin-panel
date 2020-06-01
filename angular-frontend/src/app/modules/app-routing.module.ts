import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {ProductListComponent} from '../components/product-list/product-list.component';
import {LoginComponent} from '../components/login/login.component';
import {ToolbarComponent} from '../components/toolbar/toolbar.component';
import {RegistrationComponent} from '../components/registration/registration.component';
import {DashboardComponent} from '../components/dashboard/dashboard.component';
import {AuthGuard} from '../guards/auth.guard';
import {CategoryListComponent} from '../components/category-list/category-list.component';
import {ProductComponent} from '../components/product/product.component';
import {UserSettingsComponent} from '../components/user-settings/user-settings.component';

const routes: Routes = [
  {
    path: '',
    component: ToolbarComponent,
    outlet: 'toolbar'
  },
  {path: 'admin-panel', component: DashboardComponent, canActivate: [AuthGuard]},
  {path: 'admin-panel/products', component: ProductListComponent, canActivate: [AuthGuard]},
  {path: 'admin-panel/product/:id', component: ProductComponent, canActivate: [AuthGuard]},
  {path: 'admin-panel/categories', component: CategoryListComponent, canActivate: [AuthGuard]},
  {path: 'admin-panel/settings', component: UserSettingsComponent, canActivate: [AuthGuard]},
  {path: 'login', component: LoginComponent},
  {path: 'register', component: RegistrationComponent},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})

export class AppRoutingModule {
}
