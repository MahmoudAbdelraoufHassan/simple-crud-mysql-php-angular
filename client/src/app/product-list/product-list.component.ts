import { ViewProductComponent } from './../view-product/view-product.component';
import { ApiService } from './../api/api.service';
import { Component } from '@angular/core';
import { ProductCardComponent } from "../product-card/product-card.component";
import { AddProductComponent } from '../add-product/add-product.component';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { NgClass } from '@angular/common';

@Component({
  selector: 'app-product-list',
  standalone: true,
  imports: [ProductCardComponent ,NgClass, ViewProductComponent ,ReactiveFormsModule, AddProductComponent],
  templateUrl: './product-list.component.html',
  styleUrl: './product-list.component.css'
})
export class ProductListComponent {
  productData : unknown;
  end : any;
  showViewProduct !: boolean;
  show !: boolean;
  page = 1;
  disbaleNext = false;
  disbaleprev= false;
  getId(id : number){
    this.product.getProduct(id).subscribe(e => this.productData = e)
  }
  searchInput = new FormGroup ({
    keyword : new FormControl('')
  });
  sub: any;
  Data : any;
  update : any;
  constructor(private product : ApiService){}
ngOnInit(): void {
this.sub = this.product.getProducts(this.page).subscribe(e => {
  this.Data =  e;
});
}

deleteProd(event : any){
  this.Data = event;
}
endSearch(){
  this.end = false;
  this.searchInput.get('keyword')?.setValue('');
  this.product.searchByname('').subscribe((e : any)=> {
    this.Data = e;
  })
  this.disbaleNext = false;
  this.disbaleprev= false;
}
search(){
  let keyword = this.searchInput.get('keyword')?.value as string;
  if(keyword){
  this.end = true;
  this.product.searchByname(keyword).subscribe((e : any)=> {
    this.Data = e;
  })
  this.disbaleNext = true;
  this.disbaleprev= true;
}
}
next(){
this.page +=1;
this.sub = this.product.getProducts(this.page).subscribe(e => {
  if(e.result.length > 0){
    this.Data =  e;
  }
  else {
    this.page -=1;
    this.disbaleNext = true;
  }
  if(this.disbaleprev){
    this.disbaleprev =false;
  }
});
}
prev(){
  this.page -=1;
  if(this.page >= 1){
    this.sub = this.product.getProducts(this.page).subscribe(e => {
      this.Data =  e;
      this.disbaleNext = false;
    });
}
else {
  this.disbaleprev = true;
  this.page +=1;
}
}
showPopuP(){
this.show = true;
}

closePopUp(event : any) {
  this.show = event;
}

viewProduct(event : boolean){
  this.showViewProduct = event;
  console.log(event);
}

closeView(event : any){
  console.log(event);
  this.showViewProduct = event;
}

ngOnDestroy(): void {
  this.sub.unsubscribe();
}

}
