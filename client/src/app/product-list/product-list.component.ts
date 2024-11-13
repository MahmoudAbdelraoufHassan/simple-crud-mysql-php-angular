import { ApiService } from './../api/api.service';
import { Component } from '@angular/core';
import { ProductCardComponent } from "../product-card/product-card.component";
import { filter } from 'rxjs';

@Component({
  selector: 'app-product-list',
  standalone: true,
  imports: [ProductCardComponent],
  templateUrl: './product-list.component.html',
  styleUrl: './product-list.component.css'
})
export class ProductListComponent {
  sub: any;
  Data : any;
  constructor(private product : ApiService){}
ngOnInit(): void {
this.sub = this.product.getProducts().subscribe(e => {
  this.Data =  e.result;
  console.log(this.Data);
});
}
deleteProd(event : any){
this.Data = this.Data.filter((e : any) => {
  if(e.id !== event) {
    return e
  }
})
}
ngOnDestroy(): void {

  this.sub.unsubscribe();
}
}
