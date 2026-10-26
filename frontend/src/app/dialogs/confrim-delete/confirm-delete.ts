import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { CommonModule } from '@angular/common';
import { MaterialModule } from '../../shared/material/material-module';

@Component({
  standalone: true,
  imports: [CommonModule, MaterialModule],
  templateUrl: './confirm-delete.html',
  styleUrls: ['./confirm-delete.css']
})
export class ConfirmDeleteDialogComponent {

  constructor(
    private dialogRef: MatDialogRef<ConfirmDeleteDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: { name: string }
  ) {}

  close(result: boolean) {
    this.dialogRef.close(result);
  }
}
