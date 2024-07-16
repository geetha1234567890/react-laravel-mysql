import React from 'react';
import { useTable, usePagination } from 'react-table';
import {
    Table,
    TableBody,
    TableCell,
    TableContainer,
    TableHead,
    TableRow,
    Paper,
    TableFooter,
    TablePagination,
    Switch,
    Button,
    Pagination
} from '@mui/material';

const ReactTable = ({ columns, data }) => {
    const {
        getTableProps,
        getTableBodyProps,
        headerGroups,
        prepareRow,
        page,
        canPreviousPage,
        canNextPage,
        pageOptions,
        nextPage,
        previousPage,
        state: { pageIndex, pageSize }
    } = useTable(
        {
            columns,
            data,
            initialState: { pageIndex: 0, pageSize: 5 }
        },
        usePagination
    );

    return (
        <>
            <TableContainer component={Paper}>
                <Table {...getTableProps()}>
                    <TableHead>
                        {headerGroups.map(headerGroup => (
                            <TableRow {...headerGroup.getHeaderGroupProps()}>
                                {headerGroup.headers.map(column => (
                                    <TableCell {...column.getHeaderProps()}>{column.render('Header')}</TableCell>
                                ))}
                            </TableRow>
                        ))}
                    </TableHead>
                    <TableBody {...getTableBodyProps()}>
                        {page.map(row => {
                            prepareRow(row);
                            return (
                                <TableRow {...row.getRowProps()}>
                                    {row.cells.map(cell => (
                                        <TableCell {...cell.getCellProps()}>{cell.render('Cell')}</TableCell>
                                    ))}
                                </TableRow>
                            );
                        })}
                    </TableBody>
                    <TableFooter>
                        <TableRow>
                            <TableCell colSpan={6}>
                                <div style={{ display: 'flex', justifyContent: 'center', marginTop: '20px' }}>
                                    <Button onClick={() => previousPage()} disabled={!canPreviousPage}>
                                        Previous
                                    </Button>
                                    <Button onClick={() => nextPage()} disabled={!canNextPage}>
                                        Next
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableFooter>
                </Table>
            </TableContainer>
            <div className="pagination">
                <Pagination
                    count={pageOptions.length}
                    page={pageIndex + 1}
                    onChange={(event, page) => gotoPage(page - 1)}
                    variant="outlined"
                    color="primary"
                    sx={{
                        width: '65vw',
                        display: 'flex',
                        justifyContent: 'center',
                        marginTop: '20px',
                        '.MuiPaginationItem-root': {
                            backgroundColor: '#fff',
                            border: '1px solid #ddd',
                            borderRadius: '50%',
                            width: '40px',
                            height: '40px',
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            transition: 'background-color 0.3s, transform 0.3s',
                            '&:hover': {
                                backgroundColor: '#DFDFF4',
                                transform: 'scale(1.1)',
                            },
                            '&.Mui-selected': {
                                backgroundColor: '#F56D3B',
                                color: '#fff',
                            },
                            '&.Mui-disabled': {
                                backgroundColor: '#DFDFF4',
                                cursor: 'not-allowed',
                            },
                        },
                    }}
                />
            </div>

        </>
    );
};

export default ReactTable;
