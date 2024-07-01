import React from 'react';
import { usePage } from '@inertiajs/inertia-react';

export default function TransactionSummary() {
    const { total_count, total_amount, transactions } = usePage().props;

    return (
        <div>
            <h1>Transaction Summary</h1>
            <p>Total Transactions: {total_count}</p>
            <p>Total Amount: ${total_amount}</p>
            <ul>
                {transactions.map(transaction => (
                    <li key={transaction.id}>{transaction.description}: ${transaction.amount}</li>
                ))}
            </ul>
        </div>
    );
}
